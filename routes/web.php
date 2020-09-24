<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


/* TEST ROUTES
$router->post('/test', ['middleware' => 'auth', function() {
    return config('app.name');
}]);

$router->get('/test', function() {
    return config('app.name');
});
*/

// Reorder projects
$router->post('/projects/reorder', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@reorder'
]);

// Create new project
$router->post('/projects', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@create'
]);

// delete project
$router->delete('/projects/{id}', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@delete'
]);


// update edited project
$router->patch('/projects/{id}', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@update'
]);

// photo uploads
$router->post('/projects/{id}/photo-upload', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@photoUpload'
]);

// delete photo
$router->delete('/projects/{id}/photo-delete/{photoIndex}', [
    'middleware' => 'auth',
    'uses' => 'ProjectController@photoDelete'
]);

//Below routes do not requre auth

// index of projects
$router->get('/projects', 'ProjectController@index');


$router->post('/login', function(Request $request) {
    // validate the incoming data
    $this->validate($request, ['password' => ['string','required']]);

    // check password against config var and return boolean NOTE: moved function to Controller class NOTE: Returns boolean true or false
    return Controller::checkPass($request->password);
});


$router->post('/mail/contact', function(Request $request) {

    // validate the incoming data
    $this->validate($request, [
        'name' => ['string','required'],
        'email' => ['email', 'required'],
        'textbox' => ['string', 'required']
    ]);

    // make vars and send email
    $to = 'kyle@kyleweb.dev';
	$subject = '!!!! KYLEWEB.DEV: NEW MESSAGE FROM: ' . $request->input('name') . ' !!!!';
	$message = 'Clients email: ' . $request->input('email') . "\r\n" . $request->input('name') . ' says: ' . $request->input('textbox');
	$headers = array (
		'From' => 'kylewebdevmail@gmail.com',
		'Reply-To' => $request->input('email'),
		'X-Mailer' => 'PHP/' . phpversion()
		);
    
	mail($to, $subject, $message, $headers); 

    return 'success';
});
