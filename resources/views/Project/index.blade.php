@extends('../layouts/app')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('projects.create') }}">
                Create project
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between px-4">
                Projects list
                <form action="{{ route('projects.index')  }}" method="GET" id="myForm">
                    <label for="show_deleted">Show Deleted</label>
                    <input  onchange="submitFormOnToggle()" type="checkbox" name="show_deleted" id="show_deleted" {{ old('show_deleted') ? 'checked' : '' }} {{ $showDeleted ? 'checked' : '' }}>
                </form>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Assigned to</th>
                    <th>Client</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($projectsPaginator as $project)

                    <tr>
                        <td><a href="{{ route('projects.show',$project)}}">{{ $project->title }}</a></td>
                        <td class="{{$project->user?->full_name ? '' : 'text-gray-300'}}">{{ $project->user->full_name ?? $project->user()->withTrashed()->get()->first()->full_name }}</td>
                        <td>{{ $project->client->company_name }}</td>
                        <td>{{ $project->deadline }}</td>
                        <td>{{ $project->status }}</td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('projects.edit', $project) }}">
                                Edit
                            </a>
                            @can('delete')
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $projectsPaginator->withQueryString()->links() }}
        </div>
    </div>
    <script>
        // This function will be called when the checkbox is toggled
        function submitFormOnToggle() {
            document.getElementById('show_deleted').value = document.getElementById('show_deleted').checked 
            document.getElementById('myForm').submit();
        }
    </script>
@endsection