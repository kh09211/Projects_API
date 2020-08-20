<?php

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

$router->get('/projects', 'ProjectController@index');

$router->post('/login', function(Request $request) {
    // validate the incoming data
    $this->validate($request, ['password' => ['string','required']]);

    // check password against config var and return boolean
    return (Hash::check($request->password, config('app.PASS'))) ? "true" : "false";
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
