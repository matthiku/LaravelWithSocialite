<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// CRUD routes for the categories
Route::resource('categories', 'CategoryController');
Route::get('/categories/{id}/delete',  'CategoryController@destroy');


// CRUD routes for the tasks
Route::resource('tasks', 'TaskController');
// simplifying certain routes to use get
Route::get('/tasks/{id}/delete',  'TaskController@destroy');
Route::get('/tasks/{id}/restore', 'TaskController@restore');
Route::get('/tasks/{id}/forceDelete', 'TaskController@forceDelete');


// get tasks of a certain category
Route::get('/tasks/category/{category_id}',  'TaskController@index');
// get tasks of a certain user
Route::get('/tasks/user/{user_id}',  'TaskController@index');



/**
 * Authorization routes
 */

// admin only: CRUD for users
Route::resource('users', 'UserController');

// get the form for the login - the login page
Route::get( '/',  ['as' => 'home', 'uses' => 'Auth\AuthController@getLogin']);
Route::get( 'auth/login',  'Auth\AuthController@getLogin');
// process the login data from the form
Route::post('auth/login',  'Auth\AuthController@postLogin');
// log out the user
Route::get( 'auth/logout', 'Auth\AuthController@getLogout');
// show the form to register a new user
Route::get( 'auth/register', 'Auth\AuthController@getRegister');
// process the registration of a new user
Route::post('auth/register', 'Auth\AuthController@postRegister');



// Password reset link request routes...
Route::get( 'password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get( 'password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset',         'Auth\PasswordController@postReset');



/**
 * OAuth providers and authorization
 */
Route::get('login/{provider?}',     'Auth\AuthController@loginViaProvider');

Route::get('auth/github',          'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');





/*
// using implicit controllers
Route::controller('tasks', 'TaskController');


Route::get('/dashboard', [
    'middleware' => 'age',
    function() {
        return 'This is the dashboard';
    }
]);

Route::get('/restricted', function() {
    return 'You are not allowed here!';
});


Route::any('hello/{message}', function ($message) {
    return 'Hello, '.$message;
    // Using Regex, so only letters are accepted!
})->where('message', '[A-Za-z]+');

Route::match(['get','post'], 'hello', function () {
    return 'This coutl be get or post';
});

/*
Route::get('/hello', function () {
    return "<h1>Hello World!</h1>";
});

Route::post('/hello', function () {
   return "Hello, POST!" ;
});

Route::put('/hello', function () {
   return "Hello, PUT!" ;
});

Route::delete('/hello', function () {
   return "Hello, DELETE!" ;
});
*/