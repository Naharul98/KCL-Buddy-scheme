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
//home area routes
Route::get('/', 'Home_Area\HomePageController@index');
Route::get('/home', 'Home_Area\HomePageController@index');
Route::get('/learn_more', 'Home_Area\InformationController@learnMore');

//cookie routes
Route::get('/id={id}', 'Home_Area\CookieController@insertCookie');
Route::get('/rId={id}', 'Home_Area\CookieController@deleteCookie');


//authentication routes
Auth::routes();

//user area routes
Route::get('/user_area/index', 'User_Area\DashboardController@index');
Route::get('/user_area/create_profile/{session_id}', 'User_Area\CreateProfileController@showCreateProfileView');
Route::post('/user_area/create_profile', 'User_Area\CreateProfileController@createProfile');
Route::get('/user_area/view_allocation/{session_id}', 'User_Area\ViewAllocationController@showAllocations');

Route::get('/user_area/select_session_for_signup/', 'User_Area\EligibleSignupSessionController@showSessionChoices');
Route::get('/user_area/update_profile/{session_id}', 'User_Area\UpdateProfileController@showUpdateProfileForm');
Route::post('/user_area/update_profile', 'User_Area\UpdateProfileController@updateProfile');
//gdpr info
Route::get('/user_area/data_processing_info', 'User_Area\DashboardController@showDataProcessingView');

//account delete routes
Route::get('/user_area/delete_account/{user_id}', 'User_Area\DeleteAccountController@showDeleteAccountConfirmation');
Route::post('/user_area/delete_account/{user_id}', 'User_Area\DeleteAccountController@executeDeleteAccount');

//k num verification routes
Route::get('/user_area/verify_knum', 'User_Area\VerifyKNumberController@inputKNumber')->middleware('auth');

Route::post('/user_area/verify_knum', 'User_Area\VerifyKNumberController@verifyKNumByEmail')->middleware('auth');

Route::get('/user_area/verify/{token}', 'User_Area\VerifyKNumberController@verifyUser');


//staff area routes

Route::get('/staff_area/feedback', 'Staff_Area\FeedbackController@feedback');

Route::get('/staff_area/feedback/email', 'Staff_Area\FeedbackController@emailParticipants');


//admin routes
Route::get('/staff_area/admin', 'Staff_Area\ChangeAdminController@adminBrowse');
Route::post('/staff_area/admin', 'Staff_Area\ChangeAdminController@adminBrowse');

Route::get('/staff_area/admin/update/{admin_id}', 'Staff_Area\ChangeAdminController@update');
Route::post('/staff_area/admin/update/{admin_id}', 'Staff_Area\ChangeAdminController@update');
Route::get('/staff_area/admin/delete/{admin_id}', 'Staff_Area\ChangeAdminController@delete');
Route::post('/staff_area/admin/delete/{admin_id}', 'Staff_Area\ChangeAdminController@delete');


//interests CRUD
Route::get('/staff_area/interests/index', 'Staff_Area\InterestsController@index');
Route::post('/staff_area/interests/index', 'Staff_Area\InterestsController@index');

Route::get('/staff_area/interests/create', 'Staff_Area\InterestsController@create');
Route::post('/staff_area/interests/create', 'Staff_Area\InterestsController@create');
Route::get('/staff_area/interests/update/{interest_id}', 'Staff_Area\InterestsController@update');
Route::post('/staff_area/interests/update/{interest_id}', 'Staff_Area\InterestsController@update');
Route::get('/staff_area/interests/delete/{interest_id}', 'Staff_Area\InterestsController@delete')->middleware('super_admin');
Route::post('/staff_area/interests/delete/{interest_id}', 'Staff_Area\InterestsController@delete')->middleware('super_admin');


//sessions CRUD
Route::get('/staff_area/sessions/index', 'Staff_Area\SessionsController@index');
Route::post('/staff_area/sessions/index', 'Staff_Area\SessionsController@index');

Route::get('/staff_area/sessions/create', 'Staff_Area\SessionsController@create')->middleware('super_admin');
Route::post('/staff_area/sessions/create', 'Staff_Area\SessionsController@create')->middleware('super_admin');
Route::get('/staff_area/sessions/update/{session_id}', 'Staff_Area\SessionsController@update');
Route::post('/staff_area/sessions/update/{session_id}', 'Staff_Area\SessionsController@update');
Route::get('/staff_area/sessions/delete/{session_id}', 'Staff_Area\SessionsController@delete');
Route::post('/staff_area/sessions/delete/{session_id}', 'Staff_Area\SessionsController@delete');

Route::get('/staff_area/sessions/generateLink/{session_id}', 'Staff_Area\SessionsController@generateLink');


//allocations
Route::get('/staff_area/allocations/{session_id}', 'Staff_Area\AllocationsController@displayAllocations');

Route::get('/staff_area/allocations/deallocate/{senior_id}/{junior_id}/{session_id}', 'Staff_Area\AllocationsController@deallocate');

Route::get('/staff_area/allocations/reset/{session_id}', 'Staff_Area\AllocationsController@resetNonFinalizedMatches');

Route::get('/staff_area/allocations/finalize/{session_id}', 'Staff_Area\AllocationsController@finalizeMatches');


Route::get('/staff_area/allocations/email/unallocated/{session_id}', 'Staff_Area\AllocationsController@emailUnallocatedStudents');


//manual allocation
Route::get('/staff_area/manual_allocation/{junior_id}/{session_id}', 'Staff_Area\ManualAllocationController@showEligibleSeniors');

Route::post('/staff_area/manual_allocation/{junior_id}/{session_id}', 'Staff_Area\ManualAllocationController@showEligibleSeniors');

Route::get('/staff_area/manual_allocation/allocate/{junior_id}/{senior_id}/{session_id}', 'Staff_Area\ManualAllocationController@executeAllocate');



//match routes
Route::get('/staff_area/matches/allocate/{session_id}', 'Staff_Area\GetMatchesController@populateMatchesTable');
