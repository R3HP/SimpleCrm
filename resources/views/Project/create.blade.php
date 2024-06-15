@extends('../layouts/app')
@section('content')
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="assigned_user">Assigned user</label>
                    <select class="form-control {{ $errors->has('assigned_user') ? 'is-invalid' : '' }}" name="assigned_user" id="assigned_user" required>
                        @foreach($users as $id => $entry)
                            <option value="{{ $id }}" {{ old('assigned_user') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('assigned_user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('assigned_user') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="assigned_client">Assigned client</label>
                    <select class="form-control {{ $errors->has('assigned_client') ? 'is-invalid' : '' }}" name="assigned_client" id="assigned_client" required>
                        @foreach($clients as $id => $entry)
                            <option value="{{ $id }}" {{ old('assigned_client') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('assigned_client'))
                        <div class="invalid-feedback">
                            {{ $errors->first('assigned_client') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        @foreach (App\Models\Project::Status as $status)
                            <option value="{{$status}}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>    
                        @endforeach
                        {{-- <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in progress" {{ old('status') == 'in progress' ? 'selected' : '' }}>In-progress</option>
                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option> --}}
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
                    <input class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="file"
                           name="file" id="file">
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