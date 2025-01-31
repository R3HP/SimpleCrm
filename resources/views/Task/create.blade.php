@extends('layouts.app')

@section('content')
    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">Create project</div>

            <div class="card-body">
                <div class="form-group">
                    <label class="required" for="title">Title</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title') }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label class="required" for="description">Description</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="10" name="description" id="description">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input class="form-control {{ $errors->has('deadline') ? 'is-invalid' : '' }}" type="date" name="deadline" id="deadline" value="{{ old('deadline') }}">
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
                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                            <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                            <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        {{-- <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in progress" {{ old('status') == 'in progress' ? 'selected' : '' }}>In-progress</option>
                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                        {{-- <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in progress" {{ old('status') == 'in progress' ? 'selected' : '' }}>In-progress</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="waiting client" {{ old('status') == 'waiting client' ? 'selected' : '' }}>Waiting client</option>
                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option> --}}
                    </select>
                    @if($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

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
                    Save
                </button>
            </div>
        </div>
    </form>

@endsection