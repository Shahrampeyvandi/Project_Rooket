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
// roocket.ir/admin


Route::get('/' , function (){
//    event(new \App\Events\UserActivation(\App\User::find(1)));
    return view('home');
});
Route::get('/user/active/email/{token}' , 'UserController@activation')->name('activation.account');

// namespace('Admin')->prefix('admin')
Route::group(['namespace' => 'Admin' , 'prefix' => 'admin','middleware' => 'admin'],function (){
    Route::get('/panel' , 'PanelController@index');
    Route::post('/panel/upload-image' , 'PanelController@uploadImageSubject');
    Route::resource('articles' , 'ArticleController');
    Route::resource('courses' , 'CourseController');
    Route::resource('episodes' , 'EpisodeController');
    Route::resource('roles' , 'RoleController');
    Route::resource('permissions' , 'PermissionController');

    Route::group(['prefix' => 'users'],function (){
       Route::get('/' , 'UserController@index');
       Route::resource('level' , 'LevelManageController' , ['parameters' => ['level' => 'user']]);
       Route::delete('/{user}/destroy' , 'UserController@destroy')->name('users.destroy');
    });
});

Route::group(['namespace' => 'Auth'] , function (){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Login And Register With Google
    Route::get('login/google', 'LoginController@redirectToProvider');
    Route::get('login/google/callback', 'LoginController@handleProviderCallback');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});




Route::get('/home', 'HomeController@index')->name('home');
Route::get('register', function(){
    alert()->success('متن','عنوان')->autoclose(3500);
    return redirect('/');
});