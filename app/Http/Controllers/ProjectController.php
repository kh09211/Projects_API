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
            return $this->projectsSortedByOrder();

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

    public function create(Request $request) {
        // validate the incoming data
        $this->validate($request, ['project' => ['array','required']]);
        $reqProject = $request->input('project');

        //instantiate new eloquent project object
        $project = new \App\Project;
        $project->name = $reqProject['name'];
        $project->link = $reqProject['link'];
        $project->github = $reqProject['github'];
        $project->description = $reqProject['description'];
        $project->techs = $reqProject['techs'];
        $project->photos = [];
        $project->order = (\App\Project::all()->count() + 1); //set order as the last/latest
        $project->save();

        //return to the front end the latest projects array
        return $this->projectsSortedByOrder();
    }

    public function reorder(Request $request) {
        // get projects sorted by order
        $projects = Project::all();
        $newOrdersArr = $request->input('newProjectsArrOrder');
        $sorted = $projects->sortBy('order')->values()->all();

        // reorder the projects by new order and save
        $this->reorderFunc($sorted, $newOrdersArr);

        // return to front end an updated projects array
        return $this->projectsSortedByOrder();
    }

    public function reorderFunc(Array $sortedProjects, Array $newOrdersArr) {
        // for each new id that is different from the order field, update it
        $i = 0;
        foreach ($sortedProjects as $project) {
            if ($project->order != $newOrdersArr[$i]) {
                
                $project->order = $newOrdersArr[$i];
                $project->save();
            }
            $i++;
        }
        unset($i);
    }

    public function delete($id) {
        $project = Project::find($id);
        $project->delete();

        //re-order the projects to account for deleted
        $newOrder = [];
        $count = count($this->projectsSortedByOrder());
        for ($i = 1; $i <= $count; $i++) {
            $newOrder[] = $i;
        }

        $this->reorderFunc($this->projectsSortedByOrder(), $newOrder);

        // return to front end an updated projects array
        return $this->projectsSortedByOrder();
        
    }

    private function projectsSortedByOrder() {
        return Project::all()->sortBy('order')->values()->all();
    }
}
