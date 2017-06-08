<?php

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

Auth::routes();

Route::get('/connection_opt', function () {
   $url = parse_url(getenv("DATABASE_URL"));

   $host = $url["host"];
   $username = $url["user"];
   $password = $url["pass"];
   $database = substr($url["path"], 1);
   return json_encode(array("host" => $host, "username" => $username, "password" => $password, "database" => $database));
});

Route::get('/home', function () {
    return redirect('/');
});

Route::get('sessionChecker', 'WorkerController@sessionChecker');


Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/','UnAuthorizedPersonController@Index');
Route::get('/testing', 'ClientController@testing');

Route::get('/validate_email/{verificationCode}/{email}', 'UnAuthorizedPersonController@VerifyEmail');


Route::group(['prefix' => 'socialite'], function () {
    Route::get('/redirect', 'SocialAccountController@redirect');
    Route::get('/callback', 'SocialAccountController@callback');
});


Route::group(['middleware' => ['auth', 'hasRoleAlready']], function () {
    Route::get('/selectRole', 'AuthorizedPersonController@SelectRole');
    Route::post('/selectRole', 'AuthorizedPersonController@SaveRole');
});

Route::group(['middleware' => ['auth', 'noRoleYet']], function () {
    Route::get('/client/notVerified', 'AuthorizedPersonController@ClientNotVerified');
    Route::get('/worker/notVerified', 'AuthorizedPersonController@WorkerNotVerified');
});

Route::group(['middleware' => ['auth', 'noRoleYet', 'handleRole:2']], function () {
    Route::get('/worker/skills', 'WorkerController@IndexSkill');
    Route::get('/worker/personal', 'WorkerController@IndexPersonal');
    Route::get('/worker/education', 'WorkerController@IndexEducation');
    Route::get('/worker/experience', 'WorkerController@IndexExperience');

    Route::post('/worker/cache', 'WorkerController@PutCache');
    Route::post('/worker/saveDetails', 'WorkerController@SaveDetails');
    Route::post('/worker/viewSkills', 'WorkerController@ViewSkills');
});




Route::group(['prefix' => 'client', 'middleware' => ['auth', 'noRoleYet', 'verifiedEmail', 'handleRole:1']], function () {
    Route::get('/', 'ClientController@Index');

    Route::get('/projects', 'ClientController@IndexProject');
    Route::get('/projects/create', 'ClientController@CreateProject');
    Route::post('/projects/save', 'ClientController@SaveProject');
    Route::get('/projects/created/{hashedProjectId}', 'ClientController@CreatedProject');
    Route::get('/projects/{status}/{hashedProjectId}', 'ClientController@ViewProject');
    Route::post('/projects/pay', 'ClientController@PayProject');

    Route::get('/profile', 'ClientController@IndexProfile');

    Route::post('/applicant_proposal/view', 'ClientController@ViewApplicantProposal');

    Route::post('/contract/approve', 'ClientController@ContractApprove');

    Route::post('/rate', 'ClientController@SaveRate');
    Route::post('/message/send', 'ClientController@SendMessage');
    Route::post('/message/read', 'ClientController@ReadMessage');

    Route::post('/progress/content', 'ClientController@SaveDeliverableContent');
    Route::post('/progress/comment', 'ClientController@SaveDeliverableComment');
    Route::post('/progress/deliverable/completed', 'ClientController@SaveDeliverableStatus');

});

Route::group(['prefix' => 'worker', 'middleware' => ['auth', 'noRoleYet', 'verifiedEmail', 'handleRole:2', 'basicRequirementWorker']], function () {
    Route::get('/', 'WorkerController@Index');

    Route::get('/profile', 'WorkerController@IndexProfile');

    Route::get('/works', 'WorkerController@IndexWork');
    Route::get('/works/{hashedProjectId}', 'WorkerController@ViewWork');

    Route::get('/projects', 'WorkerController@IndexProject');
    Route::get('/projects/{status}/{hashedProjectId}', 'WorkerController@ViewProject');
    Route::get('/contract_signing/{hashedContractId}', 'WorkerController@ViewContract');

    Route::post('/projects/proposal', 'WorkerController@SaveProposal');

    Route::post('/contract/approve', 'WorkerController@ContractApprove');
    //Route::post('/deliverable/file', 'WorkerController@SaveFileDeliverable');

    Route::post('/message/send', 'WorkerController@SendMessage');

    Route::post('/progress/content', 'WorkerController@SaveDeliverableContent');
    Route::post('/progress/comment', 'WorkerController@SaveDeliverableComment');
});

Route::group(['prefix' => 'coordinator', 'middleware' => ['auth', 'handleRole:3']], function () {
    Route::get('/', 'CoordinatorController@Index');
    Route::get('/projects', 'CoordinatorController@IndexProject');
    Route::get('/projects/{status}/{hashedProjectId}', 'CoordinatorController@ViewProject');
    Route::post('/projects/status/update', 'CoordinatorController@UpdateProjectStatus');

    Route::get('/profile', 'CoordinatorController@IndexProfile');
    Route::post('/projects/contract', 'CoordinatorController@SaveWorkerContract');

    Route::post('/message/send', 'CoordinatorController@SendMessage');

    Route::post('/projects/worker/assign', 'CoordinatorController@SaveWorkerProject');
});
