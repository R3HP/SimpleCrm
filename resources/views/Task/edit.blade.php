@extends('layouts.app')

@section('content')

    <div class="row">
        
        <div class="col-md-8">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
        
                <div class="card">
                    <div class="card-header">Edit project</div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="title">Title</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label class="required" for="description">Description</label>
                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="10" name="description" id="description">{{ old('description', $task->description) }}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input class="form-control {{ $errors->has('deadline') ? 'is-invalid' : '' }}" type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline) }}">
                            @if($errors->has('deadline'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('deadline') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label for="user_id">Assigned user</label>
                            <select class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $task->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user_id') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label for="client_id">Assigned client</label>
                            <select class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" name="client_id" id="client_id" required>
                                @foreach($clients as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('client_id') ? old('client_id') : $task->client->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('client_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('client_id') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label for="project_id">Assigned project</label>
                            <select class="form-control {{ $errors->has('project_id') ? 'is-invalid' : '' }}" name="project_id" id="project_id" required>
                                @foreach($projects as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('project_id') ? old('project_id') : $task->project->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('project_id') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                                @foreach (App\Models\Task::Status as $status)
                                    <option value="{{$status}}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>    
                                @endforeach
                        
                                {{-- <option value="open" {{ (old('status') ? old('status') : $task->status ?? '') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in progress" {{ (old('status') ? old('status') : $task->status ?? '') == 'in progress' ? 'selected' : '' }}>In-progress</option>
                                <option value="pending" {{ (old('status') ? old('status') : $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="waiting client" {{ (old('status') ? old('status') : $task->status ?? '') == 'waiting client' ? 'selected' : '' }}>Waiting client</option>
                                <option value="blocked" {{ (old('status') ? old('status') : $task->status ?? '') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                <option value="closed" {{ (old('status') ? old('status') : $task->status ?? '') == 'closed' ? 'selected' : '' }}>Closed</option> --}}
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block"> </span>
                        </div>
        
                        <button class="btn btn-primary" type="submit">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-4">
            <div class="card-header">Files</div>
            <div class="card-body">
                <form action="{{route('media.upload',['Task',$task])}}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="file">File</label>
                        <input class="form-controll {{ $errors->has('file') ? 'is-invalid' : '' }}"  id="file" name="file" type="file">
                        @if($errors->has('file'))
                            <div class="invalid-feedback">
                                {{ $errors->first('file') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        Upload
                    </button>
                </form>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col"> File Name </th>
                            <th scope="col"> Size </th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($task->getMedia() as $media)
                            <tr>
                                <th scope="row">{{ $media->file_name}}</th>
                                <td>{{ $media->human_readable_size }}</td>
                                <td>
                                    <a href="{{route('media.download',[$media])}}" class="btn btn-xs btn-info">Download</a>
                                    
                                    <form action="{{ route('media.delete',[$media])}}" 
                                    method="POST" onsubmit="return confirm('Are You Sure ?');" 
                                    style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection