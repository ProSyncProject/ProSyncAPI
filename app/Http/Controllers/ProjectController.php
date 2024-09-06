<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Models\Project;
use Illuminate\Support\Facades\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the project.
     */
    public function index()
    {
        try {
            $projects = Project::all();
            $projectCollection = ProjectCollection::collection($projects);
            return Response::success($projectCollection, 'Projects retrieved successfully.');
        } catch (\Exception $e) {
            return Response::error($e->getMessage());
        }
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        //
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
