<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\EditProjectRequest;
use App\Http\Requests\UploadFileRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssigned;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\error;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showDeleted = $request->show_deleted ?? false;

        $projectsPaginator = Project::with(['user', 'client'])->filterStatus(request('status'))->when($showDeleted, function ($query) {
            $query->withTrashed();
        })->paginate(20);
        return view('Project.index', compact('projectsPaginator', 'showDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->pluck('full_name', 'id');
        $clients = Client::all()->pluck('contact_name', 'id');
        return view('Project.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {

        $project = Project::create($request->validated());


        if ($request->hasFile('file')) {
            $mediaController = new MediaController;
            $req = new UploadFileRequest([], [], [], [], [
                'file' => $request->file
            ]);
            $mediaController->store($req, 'Project', $project->id);
        }

        // $project->loadMissing(['user','client']);

        $project->user()->first()->notify(new ProjectAssigned($project));

        return redirect(route('projects.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['user', 'client', 'tasks']);
        return view('Project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users = User::all()->pluck('full_name', 'id');
        $clients = Client::all()->pluck('contact_name', 'id');
        return view('Project.edit', compact('project', 'users', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProjectRequest $request, Project $project)
    {
        $validatedRequest = $request->validated();


        if ($validatedRequest['assigned_user'] !== $project->assigned_user) {

            $user = $project->user()->get()->first();

            $user->notifications()->whereJsonContains('data->id', $project->id)->delete();
        }

        $project->update($validatedRequest);



        $project->user()->first()->notify(new ProjectAssigned($project));


        return redirect(route('projects.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        abort_if(Gate::denies('delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $project->delete();
        return redirect(route('projects.index'));
    }
}
