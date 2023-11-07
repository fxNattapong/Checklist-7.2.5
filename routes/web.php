<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "HomeController@Home")->Name('Home');

Route::prefix('user')->group(function () {
    Route::get('/dashboard/{project_code}', "UserController@Dashboard")->Name('DashboardUser');
    Route::get('/dashboarduser/checklist/{project_code}/{defect_id}', "UserController@DashboardChecklist")->Name('DashboardChecklistUser');
    Route::get('/dashboarduser/checklistcomment/{project_code}/{defect_id}', "UserController@DashboardChecklistComment")->Name('DashboardChecklistCommentUser');
    Route::get('/checklist/{project_code}', "UserController@Checklist")->Name('ChecklistUser');
    Route::get('/checklist/{project_code}/{index}', "UserController@ChecklistSelected")->Name('ChecklistSelectedUser');
    Route::get('/checklist/{project_code}/{index}/search', "UserController@SearchChecklists")->Name('SearchChecklistsUser');
    Route::post('/checklist/confirm', "UserController@ChecklistConfirm")->Name('ChecklistConfirm');
    Route::post('/checklist/add', "UserController@ChecklistAdd")->Name('ChecklistAdd');
    Route::post('/checklist/edit', "UserController@ChecklistEdit")->Name('ChecklistEdit');
    Route::post('/checklist/delete', "UserController@ChecklistDelete")->Name('ChecklistDelete');
    Route::post('/checklist/success', "UserController@ChecklistSuccess")->Name('ChecklistSuccess');
    Route::post('/checklist/view', "UserController@ChecklistView")->Name('ChecklistView');
    Route::post('/comments', "UserController@ChecklistComments")->Name('ChecklistComments');
    Route::post('/comment/add', "UserController@CommentAdd")->Name('CommentAdd_User');
});

Route::prefix('admin')->group(function () {
    Route::get('/', "AdminController@Login")->Name('Login');
    Route::post('/login', "AdminController@LoginVerify")->Name('LoginVerify');
    Route::get('/register', "AdminController@Register")->Name('Register');
    Route::post('/register/store', "AdminController@RegisterStore")->Name('RegisterStore');
    Route::post('/data/account', "AdminController@DataAccount")->Name('DataAccount');
    Route::post('/account/edit', "AdminController@AccountEdit")->Name('AccountEdit');
    Route::get('/logout', "AdminController@Logout")->Name('Logout');

    Route::get('/dashboard', "AdminController@Dashboard")->Name('Dashboard')->middleware('redirectIfAuth');
    Route::get('/dashboard/checklist/{project_code}/{defect_id}', "AdminController@DashboardChecklist")->Name('DashboardChecklist')->middleware('redirectIfAuth');

    Route::get('/users', "AdminController@Users")->Name('Users')->middleware('redirectIfAuth', 'redirectIfRole');
    Route::get('/users/search', "AdminController@SearchUsers")->Name('SearchUsers')->middleware('redirectIfAuth', 'redirectIfRole');
    Route::post('/user/edit', "AdminController@UserEdit")->Name('UserEdit');
    Route::post('/user/delete', "AdminController@UserDelete")->Name('UserDelete');

    Route::get('/projects', "AdminController@Projects")->Name('Projects')->middleware('redirectIfAuth', 'redirectIfRole');
    Route::get('/projects/search', "AdminController@SearchProjects")->Name('SearchProjects')->middleware('redirectIfAuth', 'redirectIfRole');
    Route::post('/project/add', "AdminController@ProjectAdd")->Name('ProjectAdd');
    Route::post('/project/edit', "AdminController@ProjectEdit")->Name('ProjectEdit');
    Route::post('/project/delete', "AdminController@ProjectDelete")->Name('ProjectDelete');
    Route::post('/projects/log', "AdminController@ProjectsLog")->Name('ProjectsLog');

    Route::get('/checklist', "AdminController@Checklist")->Name('Checklist')->middleware('redirectIfAuth');
    Route::post('/defect/lists', "AdminController@DefectLists")->Name('DefectLists');
    Route::post('/defect/count', "AdminController@DefectCount")->Name('DefectCount');
    Route::post('/defect/add', "AdminController@DefectAdd")->Name('DefectAdd');
    Route::post('/defect/delete', "AdminController@DefectDelete")->Name('DefectDelete');
    Route::get('/checklist/{project_name}/get/export/{index}', "AdminController@ProjectExport")->Name('ProjectExport');
    Route::get('/checklist/{project_code}/{index}', "AdminController@ChecklistSelected")->Name('ChecklistSelected')->middleware('redirectIfAuth');
    Route::get('/checklist/{project_code}/{index}/search', "AdminController@SearchChecklists")->Name('SearchChecklists')->middleware('redirectIfAuth');
    Route::post('/comment/add', "AdminController@CommentAdd")->Name('CommentAdd_Admin');
    
    Route::post('/checklist/comment/log', "AdminController@CommentLog")->Name('CommentLog');
    Route::post('/checklist/comment/edit', "AdminController@CommentEdit")->Name('CommentEdit');
    Route::post('/checklist/comment/delete', "AdminController@CommentDelete")->Name('CommentDelete');
    Route::post('/checklist/project/success', "AdminController@ProjectSuccess")->Name('ProjectSuccess');

    Route::post('/checklist-mail/send/mail', "AdminController@SendMail")->Name('SendMail');
});