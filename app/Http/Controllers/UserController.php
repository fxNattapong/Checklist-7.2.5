<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Session;
use App\Models\Users;
use App\Models\Projects;
use App\Models\Defect;
use App\Models\Checklist;
use App\Models\Checklist_Comment;
use App\Models\Checklist_Comment_log;
use Storage;

// file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data)); If upload to host

class UserController extends Controller
{
    public function Dashboard($project_code='') {
        session::put('project_code', $project_code);
        $projects = DB::table('projects')
                        ->select('*')
                        ->where('project_code', '=', $project_code)
                        ->first();
        session::put('status', $projects->status);

        $checklists = DB::table('checklist')
                        ->select('*')
                        ->where('project_id', '=', $projects->id)
                        ->orderBy('created_at', 'ASC')
                        ->get();

        $checklists_status = (object)[
            'all' => 0,
            'progress' => 0,
            'done' => 0,
        ];

        $checklists_data = [];
        foreach($checklists as $checklist){
            array_push($checklists_data,(object)[
                'id' => $checklist->id,
                'title' => $checklist->title,
                'status' => $checklist->status
            ]);

            if($checklist->status == '1' || $checklist->status == '2') {
                $checklists_status->progress++; 
            }else if($checklist->status == '3') {
                $checklists_status->done++; 
            }
            $checklists_status->all++;
        }

        $projectId = $projects->id;
        $checklists_paginate = DB::table('checklist')
                                    ->select('*')
                                    ->where('project_id', '=', $projects->id)
                                    ->orderByRaw("CASE WHEN status = 3 THEN 2 ELSE 1 END, created_at DESC, status DESC")
                                    ->paginate(5, ['*'], 'checklists_page');
                                    
        $checklistsComment_paginate = DB::table('checklist_comment')
                                        ->join('checklist', 'checklist.id', '=', 'checklist_comment.checklist_id')
                                        ->join('projects', function ($join) use ($projectId) {
                                            $join->on('projects.id', '=', 'checklist.project_id')
                                                 ->where('projects.id', '=', $projectId);
                                        })
                                    ->select('checklist.title as title', 'checklist_comment.id as id', 'username', 'comment', 'checklist_comment.image as image', 
                                            'type', 'checklist_comment.type as type', 'checklist_comment.status as status', 'checklist_comment.checklist_id as checklist_id', 'checklist_comment.updated_at as updated_at')
                                    ->orderByDesc('checklist_comment.created_at')
                                    ->paginate(5, ['*'], 'checklistsComment_page');

        return view('User/Dashboard', compact('projects', 'checklists_data','checklists_status', 'checklists_paginate', 'checklistsComment_paginate'));
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
                return redirect()->route('ChecklistSelectedUser', ['project_code' => $project_code, 'index' => $loopCount]);
            }
        }
        return redirect()->route('ChecklistSelectedUser', ['project_code' => $project_code, 'index' => $loopCount]);
    }

    public function DashboardChecklistComment($project_code='', $checklist_id='') {
        $checklist = Checklist::select('defect_id')
                                ->where('id', $checklist_id)
                                ->first();

        return redirect()->route('DashboardChecklistUser', ['project_code' => $project_code, 'defect_id' => $checklist->defect_id]);
    }

    public function Checklist($project_code='') {
        session::put('project_code', $project_code);
        $projects = DB::table('projects')
                        ->select('id', 'project_name', 'image', 'status', 'project_code')
                        ->where('project_code', '=', $project_code)
                        ->first();

        $defects = DB::table('defect') 
                    ->where('project_id', $projects->id)
                    ->get();

        $checklists = DB::table('checklist')
                    ->select('status', 'defect_id')
                    ->where('project_id', $projects->id)
                    ->get();

        return view('User/Checklist', compact('projects', 'defects', 'checklists'));
    }

    public function ChecklistSelected($project_code='', $index) {
        session::put('project_code', $project_code);
        session::put('index', $index);
        $projects = Projects::select('id', 'project_name', 'image', 'status', 'project_code')
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
                return view('User/ChecklistSelected', compact('checklists_paginate', 'projects'));
            }
        }
        return view('User/Checklist', compact('projects'));
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
                                                        ->orderBy('status')
                                                        ->orderBy('status_customer')
                                                        ->orderBy('created_at', 'DESC')
                                                        ->paginate(5, ['*'], 'page');
                        }
                        break;
                    }
                    $loopCount++;
                }
                return view('User/ChecklistSelected', compact('checklists_paginate', 'projects', 'keyword'));
            }
        }
        
        return view('User/ChecklistSelected', compact('projects'));
    }
    
    public function ChecklistConfirm(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        DB::table('checklist')
            ->where('id', '=', $id)
            ->update([
                'status_customer' => '2',
                'updated_at' => now()
            ]);

        return response()->json($id, 200);
    }

    public function ChecklistAdd(Request $request) {
        $project_id = ($request->has('project_id')) ? ($request->input('project_id')) : null;
        $defect_id = ($request->has('defect_id')) ? ($request->input('defect_id')) : null;
        $title = ($request->has('title')) ? ($request->input('title')) : null;
        $detail = ($request->has('detail')) ? ($request->input('detail')) : null;
        $created_by = ($request->has('created_by')) ? ($request->input('created_by')) : null;
        $firstname = ($request->has('firstname')) ? ($request->input('firstname')) : null;
        $lastname = ($request->has('lastname')) ? ($request->input('lastname')) : null;
        $image64Array = $request->input('image64', []);

        $checklistObjects = [];

        $imageNames = [];

        foreach ($image64Array as $image64) {
            if ($image64) {
                $imageName = time() . '_' . Str::random(10) . '.png';

                list($type, $file_data) = explode(';', $image64);
                list(, $file_data) = explode(',', $file_data);
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));

                $imageNames[] = $imageName;
            }
        }

        $checklist = new Checklist;
        $checklist->project_id = $project_id;
        $checklist->defect_id = $defect_id;
        $checklist->title = $title;
        $checklist->detail = $detail;
        
        if ($firstname && $lastname) {
            $checklist->created_by = $firstname . ' ' . $lastname;
        } elseif ($created_by) {
            $checklist->created_by = $created_by;
        }
        $checklist->image = json_encode(['urls' => $imageNames]);
        $checklist->save();

        $checklistObjects[] = $checklist;

        $statusCode = 200;
        return response()->json($checklistObjects, $statusCode);
    }

    public function ChecklistEdit(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;
        $title = ($request->has('title')) ? ($request->input('title')) : null;
        $detail = ($request->has('detail')) ? ($request->input('detail')) : null;
        $status = ($request->has('status')) ? ($request->input('status')) : null;
        $image64Array = $request->input('image64', []);

        $checklist_id = Checklist_Comment::select('id')->where('checklist_id', $id)->first();

        $checklistObjects = [];

        $imageNames = [];

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
            DB::table('checklist')
                ->where('id', '=', $id)
                ->update([
                    'title' => $title,
                    'detail' => $detail,
                    'status' => $status,
                    'image' => json_encode(['urls' => $imageNames]),
                    'updated_at' => now()
                ]);

            return response()->json($checklist_id, 200);
        }

        DB::table('checklist')
            ->where('id', '=', $id)
            ->update([
                'title' => $title,
                'detail' => $detail,
                'status' => $status,
                'updated_at' => now()
            ]);
            
        return response()->json($checklist_id, 200);
    }

    public function ChecklistDelete(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $checklist = DB::table('checklist')
                    ->where('id', '=', $id)
                    ->delete();        

        $statusCode = 200;
        return response()->json($statusCode);
    }

    public function ChecklistSuccess(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        DB::table('checklist')
            ->where('id', '=', $id)
            ->update([
                'status' => '2',
                'updated_at' => now()
            ]);

        $statusCode = 200;
        return response()->json($statusCode);
    }

    public function ChecklistComments(Request $request) {
        $id = ($request->has('id')) ? ($request->input('id')) : null;

        $checklist = DB::table('checklist')
                        ->select('status')
                        ->where('id', '=', $id)
                        ->first();
        $checklist_comment = DB::table('checklist_comment')
                                ->select('*')
                                ->where('checklist_id', '=', $id)
                                ->get();
        $checklist_status = DB::table('checklist_comment')
                                ->select('status')
                                ->where('checklist_id', '=', $id)
                                ->orWhere('status', '=', '2')
                                ->first();
        if($checklist_status) {
            session::put('checklist_status', '2');
        }
            
        $statusCode = 200;
        return response()->json([$checklist, $checklist_comment], $statusCode);
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
            $InsertRow->type = '2';
            $InsertRow->status = $status;
            $InsertRow->save();

            $checklist_comment = DB::table('checklist_comment')
                                ->select('id', 'comment', 'image', 'type', 'checklist_id')
                                ->where('id', '=', $InsertRow->id)
                                ->first();
            $InsertRow = new Checklist_Comment_log;
            $InsertRow->comment_by = $username;
            $InsertRow->comment = $comment;
            $InsertRow->image = $imageName;
            $InsertRow->type = '2';
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
            $InsertRow->type = '2';
            $InsertRow->status = $status;
            $InsertRow->save();

            $checklist_comment = DB::table('checklist_comment')
                                ->select('id', 'comment', 'image', 'checklist_id')
                                ->where('id', '=', $InsertRow->id)
                                ->first();
            
            $InsertRow = new Checklist_Comment_log;
            $InsertRow->comment_by = $username;
            $InsertRow->comment = $comment;
            $InsertRow->type = '2';
            $InsertRow->status = $status;
            $InsertRow->checklist_id = $checklist_id;
            $InsertRow->action = '2';
            $InsertRow->action_by = $username;
            $InsertRow->checklist_comment_id = $checklist_comment->id;
            $InsertRow->save();
        }

        if($status == '2') {
            DB::table('checklist')
            ->where('id', '=', $checklist_id)
            ->update([
                'status' => '3',
                'updated_at' => now()
            ]);
        }

        $statusCode = 200;
        return response()->json($checklist_comment, $statusCode);
    }
}
