<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

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
            return Project::all();

        /* THIS WAS USED TO CREATE THE SQLITE DATABASE FROM THE OLD JSON FILE
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

    public function reorder(Request $request) {
        // get projects sorted by order
        $projects = Project::all();
        $newIdsArr = $request->input('newProjectsArrOrder');
        $sorted = $projects->sortBy('order')->values()->all();
        $test = [];

        
        // for each new id that is different from the order field, update it
        foreach ($sorted as $project) {
            if ($project->order != $newIdsArr[$project->order - 1]) {
                $test[] = $project->order;
                $project->order = $newIdsArr[$project->order - 1];
                $project->save();
            }
        }

        // return to front end an updated projects array
        return $projects->sortBy('order')->values()->all();
    }
}
