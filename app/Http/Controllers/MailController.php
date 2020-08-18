<?php

namespace App\Http\Controllers;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //constructor
    }

    public function contact() {
        
		
			return \App\Project::all();
	}
}
