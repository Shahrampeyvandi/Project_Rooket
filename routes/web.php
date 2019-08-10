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


Route::get('/' ,'HomeController@index');
//Route::get('Telegram' , 'TelegramController@telegram');
Route::get('articles','ArticleController@index');

// filter for courses
Route::get('courses','CourseController@index');
//end filter for courses

Route::get('article/{articleSlug}','ArticleController@single');
Route::get('courses/{courseSlug}','CourseController@single');
Route::get('/search' , 'HomeController@search');


// ----------- sitemap routes ------------

Route::get('sitemap' , 'sitemapController@index');
Route::get('sitemap-articles' , 'sitemapController@articles');
// -----------  feed route -----------------
Route::get('feed/articles' , 'feedController@articles');


// -------  DownLoad Episode Route ---------
Route::get('/download/{episode}' , 'CourseController@download');


// ---------   comments    -------------

Route::post('comment', 'HomeController@comment');

//------------ verify email ----------
Route::get('/user/active/email/{token}' , 'UserController@activation')->name('activation.account');

// namespace('Admin')->prefix('admin')

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin','middleware' =>['admin','auth:web'] ],function (){
    Route::get('/panel' , 'PanelController@index');
    Route::post('/panel/upload-image' , 'PanelController@uploadImageSubject');
    Route::resource('articles' , 'ArticleController');
    Route::resource('courses' , 'CourseController');
    Route::resource('episodes' , 'EpisodeController');
    Route::resource('roles' , 'RoleController');
    Route::resource('permissions' , 'PermissionController');
    Route::resource('comments' , 'CommentController');
    Route::get('unpublishedComments', 'CommentController@unPublishedComment');
    //menu
    Route::get('menu' ,'menuController@index')->name('menus.index');
    Route::get('menu/create' ,'menuController@create')->name('menus.create');
    Route::post('menu' ,'menuController@store')->name('menus.store');
    Route::get('menu/{menu}/edit' ,'menuController@edit')->name('menus.edit');
    Route::put('menu' ,'menuController@update')->name('menus.update');
    Route::delete('menu/{menu}' ,'menuController@destroy')->name('menus.destroy');


    // ---------- payment management -------------
    Route::get('unsuccessful' , 'paymentController@unSuccessfull');

    Route::resource('payment' , 'paymentController');
    // ---------- end payment management -------------

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
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkPhone')->name('password.phone');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::group(['middleware' => 'auth:web'], function (){
    Route::post('course/payment', 'CourseController@paymant');
    Route::get( 'course/payment/checker' , 'CourseController@checkpayment');

    // --------- user panel -----------
    Route::group(['prefix' =>'/user/panel'] , function (){
        Route::get('/' , 'UserController@index')->name('user.panel');
        Route::get('/history' , 'UserController@history')->name('user.panel.history');
        Route::get('/vip' , 'UserController@vip')->name('user.panel.vip');
        // ----- hesabe vip karbar ----------
        Route::post('paymentaccount' , 'userController@payment');
        Route::get('paymentchecker' , 'userController@checker')->name('user.paymentchecker');
    });

});


Route::get('/home', 'HomeController@index')->name('home');
// Route::get('register', function(){
//     alert()->success('متن','عنوان')->autoclose(3500);
//     return redirect('/');
// });
// Route::post('getdata',function(){
// $data=\Validator::make(request()->all(),[
//        'name' => 'required',
//        'pic' =>'required'
// ]);
// if($data->fails()){
//     return $data->errors()->all();
// }

// $year=\Carbon\Carbon::now()->year;
// $image_path="upload/images/{$year}/";
// $file=$data->file('pic');
// $fileName=$file->getClientOriginalName();
// $file->move(public_path($image_path),$fileName);
// return $image_path . $fileName;


// });
