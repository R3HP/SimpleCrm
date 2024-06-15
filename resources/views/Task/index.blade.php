@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('tasks.create') }}">
                Create task
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between px-4">
                Tasks list
                <form action="{{ route('tasks.index')  }}" method="GET" id="myForm">
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
                @foreach($tasksPaginator as $task)
                    <tr>
                        <td><a href="{{ route('tasks.show',$task)}}">{{ $task->title }}</a></td>
                        <td class="{{$task->user?->full_name ? '' : 'text-gray-300'}}">{{ $task->user->full_name ?? $task->user()->withTrashed()->get()->first()->full_name }}</td>
                        <td>{{ $task->client->company_name }}</td>
                        <td>{{ $task->deadline }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('tasks.edit', $task) }}">
                                Edit
                            </a>
                            @can('delete')
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
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

            {{ $tasksPaginator->withQueryString()->links() }}
        </div>
    </div>

@endsection