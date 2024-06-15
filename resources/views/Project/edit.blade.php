@extends('../layouts/app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">Edit project</div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="required" for="title">Title</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                               name="title" id="title" value="{{ old('title', $project->title) }}" required>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="description">Description</label>
                        <textarea class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}"
                                  rows="10" name="description"
                                  id="description">{{ old('description', $project->description) }}</textarea>
                        @if($errors->has('contact_email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('contact_email') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input class="form-control {{ $errors->has('deadline') ? 'is-invalid' : '' }}" type="date"
                               name="deadline" id="deadline" value="{{ old('deadline', $project->deadline) }}">
                        @if($errors->has('deadline'))
                            <div class="invalid-feedback">
                                {{ $errors->first('deadline') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <div class="form-group">
                        <label for="assigned_user">Assigned user</label>
                        <select class="form-control {{ $errors->has('assigned_user') ? 'is-invalid' : '' }}"
                                name="assigned_user" id="assigned_user" required>
                            @foreach($users as $id => $entry)
                                <option
                                    value="{{ $id }}" {{ (old('assigned_user') ? old('assigned_user') : $project->assigned_user ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <select class="form-control {{ $errors->has('assigned_client') ? 'is-invalid' : '' }}"
                                name="assigned_client" id="assigned_client" required>
                            @foreach($clients as $id => $entry)
                                <option
                                    value="{{ $id }}" {{ (old('assigned_client') ? old('assigned_client') : $project->assigned_client ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <label for="status">Status</label>
                        
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                                id="status" required>
                                @foreach (App\Models\Project::Status as $status)
                                    <option value="{{$status}}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>    
                                @endforeach
                            {{-- <option
                                value="open" {{ (old('status') ? old('status') : $project->status ?? '') == 'open' ? 'selected' : '' }}>
                                Open
                            </option>
                            <option
                                value="in progress" {{ (old('status') ? old('status') : $project->status ?? '') == 'in progress' ? 'selected' : '' }}>
                                In-progress
                            </option>
                            <option
                                value="blocked" {{ (old('status') ? old('status') : $project->status ?? '') == 'blocked' ? 'selected' : '' }}>
                                Blocked
                            </option>
                            <option
                                value="cancelled" {{ (old('status') ? old('status') : $project->status ?? '') == 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                            <option
                                value="completed" {{ (old('status') ? old('status') : $project->status ?? '') == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option> --}}
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
        <div class="card">
            <div class="card-header">Files</div>
            <div class="card-body">
                <form action="{{ route('media.upload', ['Project', $project]) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

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
                        Upload
                    </button>
                </form>

                <table class="table mt-4">
                    <thead>
                    <tr>
                        <th scope="col">File name</th>
                        <th scope="col">Size</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($project->getMedia() as $media)
                        <tr>
                            <th scope="row">{{ $media->file_name }}</th>
                            <td>{{ $media->human_readable_size }}</td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('media.download', $media) }}">
                                    Download
                                </a>
                                <form action="{{ route('media.delete', [$media]) }}"
                                      method="POST" onsubmit="return confirm('Are your sure?');"
                                      style="display: inline-block;">
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