<?php

namespace App\Http\Controllers;

class ProjectController extends Controller
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

    public function index() {
        
            // there is no need to convert to json because this is done automatically
            return \App\Project::all();

        /*
            foreach ($projects as $project) {
                $techs = explode(', ', $project['techs']);
                //dd($techs);

                $newProject = new \App\Project;
                $newProject->name = $project['projectname'];
                $newProject->link = $project['link'];
                $newProject->github = $project['github'];
                $newProject->photos = json_encode([$project['filename']]);
                $newProject->description = $project['description'];
                $newProject->techs = json_encode($techs);


                $newProject->save();
            
            }
        */
        }
}
