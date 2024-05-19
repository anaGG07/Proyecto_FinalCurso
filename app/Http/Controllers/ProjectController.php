<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Response;


class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::with('user:id,name')->paginate(2);
        return inertia('Projects/Index', [
            'projects' => $projects
        ]);
    }

}
