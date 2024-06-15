<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\UploadFileRequest;
use App\Mail\TaskAssigned as MailTaskAssigned;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showDeleted = $request->show_deleted ?? false;

        $tasksPaginator = Task::with(['user','client','project'])->filterStatus(request('status'))->when($showDeleted,function ($query){
            $query->withTrashed();
        })->paginate(20);

        return view('Task.index',compact('tasksPaginator','showDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all()->pluck('title','id');
        $users = User::all()->pluck('full_name','id');
        $clients = Client::all()->pluck('contact_name','id');
        return view('Task.create',compact('projects','users','clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {

        $task = Task::create($request->validated());

        if($request->hasFile('file')){
            $mediaController = new MediaController;
            $req = new UploadFileRequest([],[],[],[],[
                'file' => $request->file
            ]);
            $mediaController->store($req,'Task',$task->id);
            
        }

        $user = $task->user()->get()->first();


        Mail::to($user)->send(new MailTaskAssigned($task));

        // $user->notify(new TaskAssigned($task));

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['client','user','project']);
        return view('Task.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::all()->pluck('title','id');
        $users = User::all()->pluck('full_name','id');
        $clients = Client::all()->pluck('contact_name','id');
        return view('Task.edit',compact('task','projects','users','clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTaskRequest $request, Task $task)
    {
        $requestValidated = $request->validated();

        if($requestValidated['user_id'] !== $task->user_id){
            $user = $task->user()->get()->first();
            // $user->notifications()->whereJsonContains('data->id',$task->id)->delete();
            Mail::to($user)->send(new MailTaskAssigned($task));
        }

        $task->update($requestValidated);
        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        abort_if(Gate::denies('delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $task->delete();
        return redirect(route('tasks.index'));
    }
}
