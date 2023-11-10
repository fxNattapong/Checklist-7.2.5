<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Str;
use App\Models\Users;
use App\Models\Projects;
use App\Models\Projects_log;
use App\Models\Defect;
use App\Models\Checklist;
use App\Models\Checklist_Comment;
use App\Models\Checklist_Comment_log;
use App\Exports\ProjectExport;
use Maatwebsite\Excel\Facades\Excel;

use Mail;
// use Illuminate\Support\Facades\Mail;
use App\Mail\MyFirstEmail;

// file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data)); If upload to host

class AdminController extends Controller
{
    public function Login() {
        $data = [];
        $data['title'] = 'LoginAdmin';

        if(Session::get('authen')) {
            echo 'login already';
            echo Session::get('username');
            // die();
            return redirect('/admin/dashboard');
        }

        return view('Admin/LoginAdmin', compact('data'));
    }

    public function LoginVerify(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;

        $isUser = Users::where('username','=',$username)->where('password','=',$password)->first();

        if($isUser) {
            $resultAuthen = true;
            $result = [
                'isOk' => true, 
                'username' => $username,
                'role' => $isUser->role
            ];
            $statusCode = 200;
            session::put('authen', $resultAuthen);
            session::put('username', $username);
            session::put('firstname', $isUser->firstname);
            session::put('lastname', $isUser->lastname);
            session::put('role', $isUser->role);
            if($isUser->image) {
                session::put('image', $isUser->image);
            }
        } else {
            $resultAuthen = false;
            $result = [
                'isOk' => $resultAuthen, 
                'errorMessage' => 'err'
            ];
            $statusCode = 401;
        }

        return response()->json($result, $statusCode);
        // return redirect(Route('Login'))->with('status', $result);
    }

    public function Register() {
        $data = [];
        $data['title'] = 'RegisterAdmin';

        if(Session::get('authen')) {
            echo 'login already';
            echo Session::get('username');
            // die();
            return redirect('/admin/dashboard');
        }

        return view('Admin/RegisterAdmin', compact('data'));
    }

    public function RegisterStore(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        $firstname = ($request->has('firstname')) ? trim($request->input('firstname')) : null;
        $lastname = ($request->has('lastname')) ? trim($request->input('lastname')) : null;
        $role = ($request->has('role')) ? trim($request->input('role')) : null;
        $image64 = ($request->has('image64')) ? trim($request->input('image64')) : null;
        
        $users = DB::table('users')
                ->where('username', $username)
                ->first();

        if($users) {
            $status = 'Username in used already!';
            return response()->json(['status' => $status], 401); 
        } else {
            if($image64) {
                $base64_image = $request->input('image64'); // your base64 encoded     
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data); 
                $imageName = Str::random(10).'.'.'png';   
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));

                $InsertRow = new Users;
                $InsertRow->username = $username;
                $InsertRow->password = $password;
                $InsertRow->firstname = $firstname;
                $InsertRow->lastname = $lastname;
                if($role) {
                    $InsertRow->role = $role;
                } else {
                    $InsertRow->role = '1';
                }
                $InsertRow->image = $imageName;
                $InsertRow->save();
            } else {
                $InsertRow = new Users;
                $InsertRow->username = $username;
                $InsertRow->password = $password;
                $InsertRow->firstname = $firstname;
                $InsertRow->lastname = $lastname;
                if($role) {
                    $InsertRow->role = $role;
                } else {
                    $InsertRow->role = '1';
                }
                $InsertRow->save();
            }
            $statusCode = 200;
        }
        return response()->json($statusCode);
    }

    public function AccountEdit(Request $request) {
        $id = ($request->has('id')) ? trim($request->input('id')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        $firstname = ($request->has('firstname')) ? trim($request->input('firstname')) : null;
        $image64 = ($request->has('image64')) ? trim($request->input('image64')) : null;

        $user = DB::table('users')
                ->where('id', $id)
                ->first();

        if(!$user) {
            $status = 'Something went wrong!';
            return response()->json(['status' => $status], 401);
        } else {
            if($image64) {
                $base64_image = $request->input('image64'); // your base64 encoded     
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data); 
                $imageName = Str::random(10).'.'.'png';   
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
    
                DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                    'password' => $password,
                    'firstname' => $firstname,
                    'image' => $imageName,
                    'updated_at' => now()
                ]);
                session::put('image', $imageName);
            } else {
                DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                    'password' => $password,
                    'firstname' => $firstname,
                    'updated_at' => now()
                ]);
            }
        }
        session::put('firstname', $firstname);

        $statusCode = 200;
        return response()->json($statusCode);
    }

    public function Logout() {
        session::flush();
        session::save();
        return redirect(Route('Login'));
    }



    public function Dashboard(Request $request) {
        /* ----- Start Projects Data ----- */
        $projects = DB::table('projects')
                    ->select('id', 'start_date', 'end_date', 'project_name', 'manager_name', 'status', 'project_code')
                    ->orderBy('start_date', 'ASC');

        $projects = $projects->get();

        $projects_status = (object)[
            'all' => 0,
            'progress' => 0,
            'done' => 0,
        ];

        $projects_data = [];
        foreach($projects as $project){
            array_push($projects_data,(object)[
                'id' => $project->id,
                'start_date' => date("d-m-Y", strtotime($project->start_date)),
                'end_date' => date("d-m-Y", strtotime($project->end_date)),
                'project_name' => $project->project_name,
                'manager_name' => $project->manager_name,
                'status' => $project->status,
                'project_code' => $project->project_code
            ]);

            if($project->status == '1' || $project->status == '2') {
                $projects_status->progress++; 
            }else if($project->status == '3') {
                $projects_status->done++; 
            } 
            $projects_status->all++;
        }
        /* ------ End Project Data ----- */


        /* ----- Start Checklist Data -----  */
        $checklist = DB::table('checklist')
                    ->select('*')
                    ->orderBy('updated_at', 'DESC');
        $checklist = $checklist->get();
        /* ----- End Checklist Data -----  */


        $projects_paginate = DB::table('projects')
                                ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                ->paginate(5, ['*'], 'projects_page');
        $checklists_paginate = DB::table('checklist')
                                ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, created_at DESC, status DESC")
                                ->paginate(5, ['*'], 'checklists_page');
        return view('Admin/Dashboard', compact('checklist','projects_data','projects_status', 'projects_paginate', 'checklists_paginate'));
    }

    public function DashboardChecklist($project_code='', $defect_id='') {
        $projects = Projects::select('id', 'project_name', 'status', 'project_code')
                            ->where('project_code', $project_code)
                            ->first();

        if($projects) {
            $defects = Defect::select('id', 'status')
                        ->where('project_id', $projects->id)
                        ->get();

            if($defects->isNotEmpty()) {
                $loopCount = 1;
                foreach($defects as $defect) {
                    if($defect->id == $defect_id) {
                        break;
                    }
                    $loopCount++;
                }
                return redirect()->route('ChecklistSelected', ['project_code' => $project_code, 'index' => $loopCount]);
            }
        }
        return redirect()->route('ChecklistSelected', ['project_code' => $project_code, 'index' => $loopCount]);
    }



    public function Users(Request $request) {
        $users = DB::table('users')->select('*')->get();

        $users_paginate = DB::table('users')
                            ->orderBy('role', 'DESC')
                            ->paginate(5, ['*'], 'page');

        return view('Admin/Users', compact('users', 'users_paginate'));
    }

    public function SearchUsers(Request $request) {
        $keyword = $request->input('keyword');

        if($keyword) {
            $users_paginate = Users::where('username', 'like', "%$keyword%")
                                    ->orWhere('firstname', 'like', "%$keyword%")
                                    ->orWhere('lastname', 'like', "%$keyword%")
                                    ->orderBy('role', 'DESC')
                                    ->paginate(5, ['*'], 'page');
        } else {
            $users_paginate = DB::table('users')
                                ->orderBy('role', 'DESC')
                                ->paginate(5, ['*'], 'page');
        }

        return view('Admin/Users', compact('users_paginate', 'keyword'));
    }

    public function UserEdit(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $firstname = ($request->has('firstname')) ? ($request->input('firstname')) : null;
        $lastname = ($request->has('lastname')) ? ($request->input('lastname')) : null;
        $username = ($request->has('username')) ? ($request->input('username')) : null;
        $username_current = ($request->has('username_current')) ? ($request->input('username_current')) : null;
        $password = ($request->has('password')) ? ($request->input('password')) : null;
        $role = ($request->has('role')) ? ($request->input('role')) : null;
        $image64 = ($request->has('image64')) ? ($request->input('image64')) : null;

        if($username != $username_current) {
            $users = DB::table('users')
                ->where('username', $username)
                ->first();
            if($users) {
                $status = 'Username in used already!';
                return response()->json(['status' => $status], 401); 
            } else {
                if($image64) {
                    $base64_image = $request->input('image64'); // your base64 encoded     
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data); 
                    $imageName = Str::random(10).'.'.'png';   
                    file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
        
                    DB::table('users')
                        ->where('id', '=', $id)
                        ->update([
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role,
                        'image' => $imageName,
                        'updated_at' => now()
                    ]);
                    session::put('image', $imageName);
                } else {
                    DB::table('users')
                        ->where('id', '=', $id)
                        ->update([
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role,
                        'updated_at' => now()
                    ]);
                }
            }
        } else {
            if($image64) {
                $base64_image = $request->input('image64'); // your base64 encoded     
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data); 
                $imageName = Str::random(10).'.'.'png';   
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
    
                DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'password' => $password,
                    'role' => $role,
                    'image' => $imageName,
                    'updated_at' => now()
                ]);
                session::put('image', $imageName);
            } else {
                DB::table('users')
                    ->where('id', '=', $id)
                    ->update([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'password' => $password,
                    'role' => $role,
                    'updated_at' => now()
                ]);
            }
        }

        $status = 1;
        return redirect(Route('Users'))->with('status', $status);
    }

    public function UserDelete(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $user = DB::table('users')
                    ->where('id', '=', $id)
                    ->delete();        

        $statusCode = 200;
        return response()->json($statusCode);
    }

    public function DataAccount(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;

        $user = DB::table('users')
                ->where('username', $username)
                ->first();

        $statusCode = 200;
        return response()->json($user, $statusCode);
    }



    public function Projects(Request $request) {
        $projects = DB::table('projects')->select('*')->get();

        $projects_paginate = DB::table('projects')
                                ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                ->paginate(5, ['*'], 'page');

        return view('Admin/Projects', compact('projects', 'projects_paginate'));
    }

    public function SearchProjects(Request $request) {
        $keyword = $request->input('keyword');
        $start_date_search = $request->input('start_date_search');
        $end_date_search = $request->input('end_date_search');

        $status = null;

        if($keyword == "กำลังดำเนินการ" || $keyword == "กำ" || $keyword == "กำลัง" || $keyword == "ดำเนินการ") {
            $status = 1;
        } elseif($keyword == "ขยายระยะเวลา" || $keyword == "ขยาย" || $keyword == "ระยะ") {
            $status = 2;
        } elseif($keyword == "เสร็จสิ้น" || $keyword == "เสร็จ" || $keyword == "สิ้น") {
            $status = 3;
        }

        if($start_date_search != '' && $end_date_search != '') {
            $projects_paginate = Projects::where(function($query) use ($start_date_search, $end_date_search) {
                                    $query->whereBetween('start_date', [$start_date_search, $end_date_search])
                                        ->orWhereBetween('end_date', [$start_date_search, $end_date_search]);
                                })
                                ->where(function($query) use ($keyword, $status) {
                                    $query->where('project_name', 'like', "%$keyword%")
                                        ->orWhere('manager_name', 'like', "%$keyword%")
                                        ->orWhere('description', 'like', "%$keyword%");
                                    if ($status !== null) {
                                        $query->orWhere('status', $status);
                                    }
                                })
                                ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                ->paginate(5, ['*'], 'page');
        } else if($keyword) {
            $projects_paginate = Projects::where(function($query) use ($keyword, $status, $start_date_search, $end_date_search) {
                                    $query->where('project_name', 'like', "%$keyword%")
                                        ->orWhere('manager_name', 'like', "%$keyword%")
                                        ->orWhere('description', 'like', "%$keyword%");
                                        if ($status !== null) {
                                            $query->orWhere('status', $status);
                                        }
                                    })
                                    ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                    ->paginate(5, ['*'], 'page');
        } else {
            $projects_paginate = DB::table('projects')
                                    ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                    ->paginate(5, ['*'], 'page');
        }

        return view('Admin/Projects', compact('projects_paginate', 'keyword', 'start_date_search', 'end_date_search'));
    }

    public function ProjectAdd(Request $request) {
        $start_date = ($request->has('start_date')) ? ($request->input('start_date')) : null;
        $end_date = ($request->has('end_date')) ? ($request->input('end_date')) : null;
        $email_company = ($request->has('email_company')) ? ($request->input('email_company')) : null;
        $email_customer = ($request->has('email_customer')) ? ($request->input('email_customer')) : null;
        $project_name = ($request->has('project_name')) ? ($request->input('project_name')) : null;
        $manager_name = ($request->has('manager_name')) ? ($request->input('manager_name')) : null;
        $description = ($request->has('description')) ? ($request->input('description')) : null;

        $project = DB::table('projects')
                ->where('project_name', $project_name)
                ->first();

        if($project) {
            $status = 'Project name in used already!';
            return response()->json(['status' => $status], 401);
        } else {
            $base64_image = $request->input('image64'); // your base64 encoded     
            @list($type, $file_data) = explode(';', $base64_image);
            @list(, $file_data) = explode(',', $file_data); 
            $imageName = Str::random(10).'.'.'png';
            file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));

            $InsertRow = new Projects;
            $InsertRow->start_date = $start_date;
            $InsertRow->end_date = $end_date;
            $InsertRow->email_company = $email_company;
            $InsertRow->email_customer = $email_customer;
            $InsertRow->project_name = $project_name;
            $InsertRow->manager_name = $manager_name;
            if($description) {
                $InsertRow->description = $description;
            }
            $InsertRow->image = $imageName;
            $InsertRow->project_code = Str::lower(Str::random(10));;
            $InsertRow->save();

            $project = DB::table('projects')
                    ->where('project_name', $project_name)
                    ->first();

            $InsertRow = new Projects_log;
            $InsertRow->start_date = $start_date;
            $InsertRow->end_date = $end_date;
            $InsertRow->email_company = $email_company;
            $InsertRow->email_customer = $email_customer;
            $InsertRow->reason = 'สร้างครั้งแรก';
            $InsertRow->status = '1';
            if($imageName) {
                $InsertRow->image = $imageName;
            }
            $InsertRow->project_id = $project->id;
            $InsertRow->fullname = 'สร้างครั้งแรก';
            $InsertRow->save();
            
            $status = 1;
        }
        
        return redirect(Route('Projects'))->with('status', $status);
    }

    public function ProjectEdit(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $start_date = ($request->has('start_date')) ? ($request->input('start_date')) : null;
        $end_date = ($request->has('end_date')) ? ($request->input('end_date')) : null;
        $end_date_current = ($request->has('end_date_current')) ? ($request->input('end_date_current')) : null;
        $project_name = ($request->has('project_name')) ? ($request->input('project_name')) : null;
        $project_name_current = ($request->has('project_name_current')) ? ($request->input('project_name_current')) : null;
        $email_company = ($request->has('email_company')) ? ($request->input('email_company')) : null;
        $email_customer = ($request->has('email_customer')) ? ($request->input('email_customer')) : null;
        $manager_name = ($request->has('manager_name')) ? ($request->input('manager_name')) : null;
        $description = ($request->has('description')) ? ($request->input('description')) : null;
        $status = ($request->has('status')) ? ($request->input('status')) : null;
        $image64 = ($request->has('image64')) ? ($request->input('image64')) : null;

        $reason = ($request->has('reason')) ? ($request->input('reason')) : null;
        $firstname = ($request->has('firstname')) ? ($request->input('firstname')) : null;
        $lastname = ($request->has('lastname')) ? ($request->input('lastname')) : null;
        $fullname = $firstname . ' ' . $lastname;

        if($project_name != $project_name_current) {
            $project = DB::table('projects')
                ->where('project_name', $project_name)
                ->first();
            if($project) {
                $status = 'Project name in used already!';
                return response()->json(['status' => $status], 401); 
            } else {
                if($image64) {
                    $base64_image = $request->input('image64'); // your base64 encoded     
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data); 
                    $imageName = Str::random(10).'.'.'png';   
                    file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
        
                    if($end_date == $end_date_current) {
                        DB::table('projects')
                            ->where('id', '=', $id)
                            ->update([
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'email_company' => $email_company,
                            'email_customer' => $email_customer,
                            'project_name' => $project_name,
                            'manager_name' => $manager_name,
                            'description' => $description,
                            'image' => $imageName,
                            'status' => $status,
                            'updated_at' => now()
                        ]);
                    } else {
                        DB::table('projects')
                        ->where('id', '=', $id)
                        ->update([
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'email_company' => $email_company,
                            'email_customer' => $email_customer,
                            'project_name' => $project_name,
                            'manager_name' => $manager_name,
                            'description' => $description,
                            'image' => $imageName,
                            'status' => '2',
                            'updated_at' => now()
                        ]);
                    }
                } else {
                    if($end_date == $end_date_current) {
                        DB::table('projects')
                        ->where('id', '=', $id)
                        ->update([
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'email_company' => $email_company,
                            'email_customer' => $email_customer,
                            'project_name' => $project_name,
                            'manager_name' => $manager_name,
                            'description' => $description,
                            'status' => $status,
                            'updated_at' => now()
                        ]);
                    } else {
                        DB::table('projects')
                        ->where('id', '=', $id)
                        ->update([
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'email_company' => $email_company,
                            'email_customer' => $email_customer,
                            'project_name' => $project_name,
                            'manager_name' => $manager_name,
                            'description' => $description,
                            'status' => '2',
                            'updated_at' => now()
                        ]);
                    }
                }
            }
            $status = 1;
            return redirect(Route('Projects'))->with('status', $status);
        } else {
            if($image64) {
                $base64_image = $request->input('image64'); // your base64 encoded     
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data); 
                $imageName = Str::random(10).'.'.'png';   
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
    
                if($end_date == $end_date_current) {
                    DB::table('projects')
                    ->where('id', '=', $id)
                    ->update([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'email_company' => $email_company,
                        'email_customer' => $email_customer,
                        'project_name' => $project_name,
                        'manager_name' => $manager_name,
                        'description' => $description,
                        'image' => $imageName,
                        'status' => $status,
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('projects')
                    ->where('id', '=', $id)
                    ->update([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'email_company' => $email_company,
                        'email_customer' => $email_customer,
                        'project_name' => $project_name,
                        'manager_name' => $manager_name,
                        'description' => $description,
                        'image' => $imageName,
                        'status' => '2',
                        'updated_at' => now()
                    ]);
                }
                
            } else {
                if($end_date == $end_date_current) {
                    DB::table('projects')
                    ->where('id', '=', $id)
                    ->update([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'email_company' => $email_company,
                        'email_customer' => $email_customer,
                        'project_name' => $project_name,
                        'manager_name' => $manager_name,
                        'description' => $description,
                        'status' => $status,
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('projects')
                    ->where('id', '=', $id)
                    ->update([
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'email_company' => $email_company,
                        'email_customer' => $email_customer,
                        'project_name' => $project_name,
                        'manager_name' => $manager_name,
                        'description' => $description,
                        'status' => '2',
                        'updated_at' => now()
                    ]);
                }
                
            }
        }

        $latest_log = DB::table('projects_log')
                        ->select('image')
                        ->where('project_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->first();
        $InsertRow = new Projects_log;
        $InsertRow->start_date = $start_date;
        $InsertRow->end_date = $end_date;
        $InsertRow->email_company = $email_company;
        $InsertRow->email_customer = $email_customer;
        $InsertRow->reason = $reason;
        $InsertRow->status = $status;
        $InsertRow->image = $latest_log->image;
        $InsertRow->project_id = $id;
        $InsertRow->fullname = $fullname;
        $InsertRow->save();

        $status = 1;
        return redirect(Route('Projects'))->with('status', $status);
    }

    public function ProjectDelete(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $projects = DB::table('projects')
                    ->where('id', '=', $id)
                    ->delete();
                    
        $projects_log = DB::table('projects_log')
                    ->where('project_id', '=', $id)
                    ->delete();

        return response()->json(200);
    }

    public function ProjectsLog(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $project_logs = DB::table('projects_log')
                            ->select('*')
                            ->where('project_id', '=', $id)
                            ->orderBy('updated_at', 'DESC')
                            ->get();

        $statusCode = 200;
        return response()->json($project_logs, $statusCode);
    }



    public function Checklist() {
        $projects = DB::table('projects')->select('*')->get();

        
        $projects_paginate = DB::table('projects')
                                ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, end_date ASC, status DESC")
                                ->paginate(5, ['*'], 'page');
        
        return view('Admin/Checklist', compact('projects', 'projects_paginate'));
    }

    public function DefectLists(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $project = DB::table('projects')->select('status')->where('id', $id)->first();

        $result = (object)[
            'proejct_status' => (!empty($project)) ? $project->status : '',
            'defects' => []
        ];

        $defect = DB::table('defect')->select('id', 'status', 'count')
                    ->where('project_id', $id)
                    ->orderBy('count')
                    ->get();
        if($defect->count()){            
            foreach($defect as $key => $val){
                $defectInfo = (object)[
                    'id' => $val->id,
                    'status' => $val->status,
                    'count' => $val->count,
                    'checklist' => (object)[
                        'all' => Checklist::select('id')->where('defect_id',$val->id)->get()->count(),
                        'done' => Checklist::select('id')->where('defect_id',$val->id)->where('status',3)->get()->count()
                    ]
                ];

                array_push($result->defects,$defectInfo);
            }
        }
        return response()->json($result, 200);
        // return response()->json([$defect, $checklists, $projects], $statusCode);
    }

    public function DefectCount(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $defect = DB::table('defect') 
                    ->where('project_id', $id)
                    ->get();

        $statusCode = 200;
        return response()->json($defect, $statusCode);
    }

    public function DefectAdd(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $count = Defect::select('id')->where('project_id', $id)->get()->count();
        $count = $count+1;

        $InsertRow = new Defect;
        $InsertRow->project_id = $id;
        $InsertRow->count = $count;
        $InsertRow->save();

        $newInsertedId = $InsertRow->id;

        return response()->json([$count, $newInsertedId], 200);
    }

    public function DefectDelete(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $defect = DB::table('defect')
                    ->where('id', '=', $id)
                    ->delete();

        return response()->json(200);
    }

    public function ChecklistSelected($project_code='', $index='') {
        session::put('project_code', $project_code);
        session::put('index', $index);
        $projects = Projects::select('id', 'project_name', 'status', 'project_code')
                            ->where('project_code', $project_code)
                            ->first();

        if($projects) {
            $defects = Defect::select('id', 'status')
                        ->where('project_id', $projects->id)
                        ->get();

            if($defects->isNotEmpty()) {
                $loopCount = 1;
                foreach($defects as $defect) {
                    if($loopCount == $index) {
                        session::put('defect_id', $defect->id);
                        if($defect->status == '1') {
                            session::put('defect', 'Defect รับประกันผลงาน');
                        } else {
                            session::put('defect', 'Defect ครั้งที่ '.$loopCount);
                        }
                        $checklists_paginate = DB::table('checklist')
                                                ->select('*')
                                                ->where('project_id', $projects->id)
                                                ->where('defect_id', $defect->id)
                                                ->orderBy('status')
                                                ->orderBy('status_customer')
                                                ->orderBy('created_at', 'DESC')
                                                ->paginate(5, ['*'], 'page');
                        break;
                    }
                    $loopCount++;
                }
                return view('Admin/ChecklistSelected', compact('checklists_paginate', 'projects'));
            }

        }
        
        return view('Admin/ChecklistSelected', compact('projects'));
    }

    public function SearchChecklists(Request $request, $project_code='', $index='') {
        $keyword = $request->input('keyword');
        $status = null;
        $status_customer = null;

        session::put('project_code', $project_code);
        session::put('index', $index);
        $projects = Projects::select('id', 'project_name', 'status', 'project_code')
                            ->where('project_code', $project_code)
                            ->first();

        if($projects) {
            $defects = Defect::select('id', 'status')
                        ->where('project_id', $projects->id)
                        ->get();

            if($defects->isNotEmpty()) {
                $loopCount = 1;
                foreach($defects as $defect) {
                    if($loopCount == $index) {
                        session::put('defect_id', $defect->id);
                        if($defect->status == '1') {
                            session::put('defect', 'Defect รับประกันผลงาน');
                        } else {
                            session::put('defect', 'Defect ครั้งที่ '.$loopCount);
                        }

                        if($keyword) {

                            // $getStatusID = [];
                            // $getStatus = StatusTB::Select('id')->Where('title', 'like', "%$keyword%")->get();
                            // foreach($getStatus as $key= > $value){
                            //     array_push($getStatusID,$value->id);
                            // }

                            // $getStatusID = [0,1,2];


                            if($keyword == "รอดำเนินการ" || $keyword == "รอ" || $keyword == "รอดำ" || $keyword == "รอดำเนิน") {
                                $status = 1;
                            } elseif($keyword == "กำลังดำเนินการ" || $keyword == "กำ" || $keyword == "กำลัง" || $keyword == "กำลังดำ" || $keyword == "กำลังดำเนิน") {
                                $status = 2;
                            } elseif($keyword == "เสร็จสิ้น" || $keyword == "เสร็จ") {
                                $status = 3;
                            }

                            if($keyword == "รอตรวจสอบ") {
                                $status_customer = 1;
                            } elseif($keyword == "ตรวจสอบแล้ว" || $keyword == "แล้ว") {
                                $status_customer = 2;
                            }
                            $checklists_paginate = Checklist::select('*')
                                                            ->where('project_id', $projects->id)
                                                            ->where('defect_id', $defect->id)
                                                            ->where(function($query) use ($keyword, $status, $status_customer) {
                                                                $query->where('title', 'like', "%$keyword%")
                                                                    ->orWhere('detail', 'like', "%$keyword%")
                                                                    ->orWhere('created_by', 'like', "%$keyword%");
                                                                    if ($status !== null) {
                                                                        $query->orWhere('status', $status);
                                                                    }
                                                                    if ($status_customer !== null) {
                                                                        $query->orWhere('status_customer', $status_customer);
                                                                    }
                                                            })
                                                            ->orderBy('status')
                                                            ->orderBy('status_customer')
                                                            ->orderBy('created_at', 'DESC')
                                                            ->paginate(5, ['*'], 'page');
                        } else {
                            $checklists_paginate = DB::table('checklist')
                                                        ->select('*')
                                                        ->where('project_id', $projects->id)
                                                        ->where('defect_id', $defect->id)
                                                        ->orderBy('created_at', 'DESC')
                                                        ->paginate(5, ['*'], 'page');
                        }
                        break;
                    }
                    $loopCount++;
                }
                return view('Admin/ChecklistSelected', compact('checklists_paginate', 'projects', 'keyword'));
            }
        }
        
        return view('Admin/ChecklistSelected', compact('projects'));
    }

    public function CommentAdd(Request $request) {
        $checklist_id = ($request->has('checklist_id')) ? ($request->input('checklist_id')) : null;
        $username = ($request->has('username')) ? ($request->input('username')) : null;
        $comment = ($request->has('comment')) ? ($request->input('comment')) : null;
        $image64 = ($request->has('image64')) ? ($request->input('image64')) : null;
        $status = ($request->has('status')) ? ($request->input('status')) : null;

        $image64Array = $request->input('image64', []);

        if($image64Array) {
            foreach ($image64Array as $image64) {
                $imageName = time() . '_' . Str::random(10) . '.png';
                list($type, $file_data) = explode(';', $image64);
                list(, $file_data) = explode(',', $file_data);
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
            }
            $InsertRow = new Checklist_Comment;
            $InsertRow->username = $username;
            $InsertRow->comment = $comment;
            $InsertRow->checklist_id = $checklist_id;
            $InsertRow->image = $imageName;
            $InsertRow->type = '1';
            $InsertRow->status = $status;
            $InsertRow->save();

            $checklist_comment = DB::table('checklist_comment')
                                ->select('id', 'comment', 'image', 'checklist_id')
                                ->where('id', '=', $InsertRow->id)
                                ->first();
            $InsertRow = new Checklist_Comment_log;
            $InsertRow->comment_by = $username;
            $InsertRow->comment = $comment;
            $InsertRow->image = $imageName;
            $InsertRow->type = '1';
            $InsertRow->status = $status;
            $InsertRow->checklist_id = $checklist_id;
            $InsertRow->action = '2';
            $InsertRow->action_by = $username;
            $InsertRow->checklist_comment_id = $checklist_comment->id;
            $InsertRow->save();
        } else {
            $InsertRow = new Checklist_Comment;
            $InsertRow->username = $username;
            $InsertRow->comment = $comment;
            $InsertRow->checklist_id = $checklist_id;
            $InsertRow->type = '1';
            $InsertRow->status = $status;
            $InsertRow->save();

            $checklist_comment = DB::table('checklist_comment')
                                ->select('id', 'username', 'comment', 'image', 'checklist_id')
                                ->where('id', '=', $InsertRow->id)
                                ->first();
            $InsertRow = new Checklist_Comment_log;
            $InsertRow->comment_by = $username;
            $InsertRow->comment = $comment;
            $InsertRow->type = '1';
            $InsertRow->status = $status;
            $InsertRow->checklist_id = $checklist_id;
            $InsertRow->action = '2';
            $InsertRow->action_by = $username;
            $InsertRow->checklist_comment_id = $checklist_comment->id;
            $InsertRow->save();
        }

        DB::table('checklist')
            ->where('id', '=', $checklist_id)
            ->update([
                'status' => '2',
                'updated_at' => now()
            ]);

        if($status == '2') {
            DB::table('checklist')
            ->where('id', '=', $checklist_id)
            ->update([
                'status' => '3',
                'updated_at' => now()
            ]);
        }

        $statusCode = 200;
        // return redirect()->back()->with('status', $statusCode);
        return response()->json($checklist_comment, $statusCode);
    }

    public function ProjectExport($project_id='', $defect_id='', $index='') {
        $project = Projects::where('id', '=', $project_id)->first();

        Session::put('index', $index);

        $defect = Projects::where('id', '=', $defect_id)->first();

        if($defect->status == '1') {
            return Excel::download(new ProjectExport($project_id, $defect_id), 'Export_Defect-Done' . '_' . $project->project_name . '.xlsx');
        } else {
            return Excel::download(new ProjectExport($project_id, $defect_id), 'Export_Defect-' . $index . '_' . $project->project_name . '.xlsx');
        }

        
    }

    public function CommentLog(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $checklist_comment_log = DB::table('checklist_comment_log')
                                    ->select('*')
                                    ->where('checklist_comment_id', '=', $id)
                                    ->orderBy('updated_at', 'DESC')
                                    ->get();

        $statusCode = 200;
        return response()->json($checklist_comment_log, $statusCode);
    }

    public function CommentEdit(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $comment = ($request->has('comment')) ? ($request->input('comment')) : null;
        $action_by = ($request->has('action_by')) ? ($request->input('action_by')) : null;
        $image64 = ($request->has('image64')) ? ($request->input('image64')) : null;

        $image64Array = $request->input('image64', []);

        $checklist_comment = DB::table('checklist_comment')
                        ->select('*')
                        ->where('id', '=', $id)
                        ->first();

        $checklist = DB::table('checklist')
                        ->select('*')
                        ->where('id', '=', $checklist_comment->checklist_id)
                        ->first();

        $checklistObjects = [];

        $imageNames = [];

        if(!$checklist_comment) {
            $status = 'Something went wrong!';
            return response()->json(['status' => $status], 401); 
        } else {
            if($image64Array) {
                foreach ($image64Array as $image64) {
                    if ($image64) {
                        $imageName = time() . '_' . Str::random(10) . '.png';
                        list($type, $file_data) = explode(';', $image64);
                        list(, $file_data) = explode(',', $file_data);
                        file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
        
                        $imageNames[] = $imageName;
                    }
                }
                DB::table('checklist_comment')
                    ->where('id', '=', $id)
                    ->update([
                        'comment' => $comment,
                        'image' => $imageName,
                        'updated_at' => now()
                    ]);
    
                $InsertRow = new Checklist_Comment_log;
                $InsertRow->comment_by = $checklist_comment->username;
                $InsertRow->comment = $checklist_comment->comment;
                $InsertRow->image = $imageName;
                $InsertRow->type = $checklist_comment->type;
                $InsertRow->status = $checklist_comment->status;
                $InsertRow->checklist_id = $checklist_comment->checklist_id;
                $InsertRow->action = '0';
                $InsertRow->action_by = $action_by;
                $InsertRow->checklist_comment_id = $id;
                $InsertRow->save();
    
                $statusCode = 200;
                return response()->json($checklist->id, $statusCode);
            }
            DB::table('checklist_comment')
                ->where('id', '=', $id)
                ->update([
                    'comment' => $comment,
                    'updated_at' => now()
                ]);
    
            $InsertRow = new Checklist_Comment_log;
            $InsertRow->comment_by = $checklist_comment->username;
            $InsertRow->comment = $comment;
            $InsertRow->image = $checklist_comment->image;
            $InsertRow->type = $checklist_comment->type;
            $InsertRow->status = $checklist_comment->status;
            $InsertRow->checklist_id = $checklist_comment->checklist_id;
            $InsertRow->action = '0';
            $InsertRow->action_by = $action_by;
            $InsertRow->checklist_comment_id = $id;
            $InsertRow->save();
        }
            

        $statusCode = 200;
        return response()->json($checklist->id, $statusCode);
    }

    public function CommentDelete(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $action_by = ($request->has('action_by')) ? ($request->input('action_by')) : null;

        $checklist_comment = DB::table('checklist_comment')
                            ->select('*')
                            ->where('id', '=', $id)
                            ->first();

        $InsertRow = new Checklist_Comment_log;
        $InsertRow->comment_by = $checklist_comment->username;
        $InsertRow->comment = $checklist_comment->comment;
        $InsertRow->image = $checklist_comment->image;
        $InsertRow->type = $checklist_comment->type;
        $InsertRow->status = $checklist_comment->status;
        $InsertRow->checklist_id = $checklist_comment->checklist_id;
        $InsertRow->action = '1';   //1 = delete
        $InsertRow->action_by = $action_by;
        $InsertRow->checklist_comment_id = $id;
        $InsertRow->save();

        DB::table('checklist_comment')
            ->where('id', '=', $id)
            ->update([
                'status' => '3', // 3 = delete
                'updated_at' => now()
            ]);

        $statusCode = 200;
        return response()->json($checklist_comment, $statusCode);
    }

    public function ProjectSuccess(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $reason = ($request->has('reason')) ? ($request->input('reason')) : null;
        $firstname = ($request->has('firstname')) ? ($request->input('firstname')) : null;
        $lastname = ($request->has('lastname')) ? ($request->input('lastname')) : null;
        $fullname = $firstname . ' ' . $lastname;
            
        DB::table('projects')
            ->where('id', '=', $id)
            ->update([
                'status' => '3', // 3 = done
                'updated_at' => now()
            ]);

        $project = DB::table('projects')
                    ->select('start_date', 'end_date', 'email_company', 'email_customer', 'image')
                    ->where('id', $id)
                    ->first();

        $InsertRow = new Projects_log;
        $InsertRow->start_date = $project->start_date;
        $InsertRow->end_date = $project->end_date;
        $InsertRow->email_company = $project->email_company;
        $InsertRow->email_customer = $project->email_customer;
        $InsertRow->reason = $reason;
        $InsertRow->status = '3';
        $InsertRow->image = $project->image;
        $InsertRow->project_id = $id;
        $InsertRow->fullname = $fullname;
        $InsertRow->save();
        
        $count = Defect::select('id')->where('project_id', $id)->get()->count();
        $count = $count+1;

        $InsertRow = new Defect;
        $InsertRow->project_id = $id;
        $InsertRow->status = '1'; // 1 = done
        $InsertRow->count = $count;
        $InsertRow->save();

        return response()->json(200);
    }

    public function SendMail(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $checklist_comment = Checklist_Comment::where('id', $id)->first();

        $checklist = Checklist::where('id', $checklist_comment->checklist_id)->first();

        $defect = Defect::where('id', $checklist->defect_id)->first();
        
        $project = Projects::where('id', $checklist->project_id)->first();

        $checklist_all = Checklist::where('defect_id',  $checklist->defect_id)->get()->count();
        $checklist_done = Checklist::where('defect_id',  $checklist->defect_id)->where('status', 3)->get()->count();

        $defects = Defect::where('project_id', $project->id)->get();
        $loopCount = 1;
        $DefectText = 'No value';
        foreach($defects as $val) {
            if($val->id == $defect->id) {
                if($val->status == '1') {
                    $DefectText = 'Defect รับประกันผลงาน';
                } else {
                    $DefectText = 'Defect ครั้งที่ ' . $loopCount;
                }
                break;
            }
            $loopCount++;
        }

        $data = [
            'project' => $project,
            'checklist' => $checklist,
            'defect' => $defect,
            'checklist_comment' => $checklist_comment,
            'DefectText' => $DefectText
        ];

        // return view('emails.my_first_email', ['data' => $data]);
        

        if($project->email_customer && $checklist_done == $checklist_all) {
            // Mail::to($project->email_company)->send(new MyFirstEmail($project, $checklist, $defect, $checklist_comment, $DefectText, $send_by));

            Mail::send('Emails.my_first_email', ['data' => $data], function($message) use($data){
                $message->to($data['project']->email_customer);
                $message->subject('Checklist System');
                $message->from($data['project']->email_company, 'Kingsmen C.M.T.I. Plc.');
            });
        }

        return response()->json($checklist_done, 200);
    }
}
