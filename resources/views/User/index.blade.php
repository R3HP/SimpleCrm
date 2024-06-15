@extends('../layouts/app')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('users.create') }}">
                Create user
            </a>
        </div>
    </div>

    <div class="card">
        
        <div class="card-header">
            <div class="row justify-content-between px-4">
                Users List
                <form action="{{ route('users.index')  }}" method="GET" id="myForm">
                    <label for="show_deleted">Show Deleted</label>
                    <input  onchange="submitFormOnToggle()" type="checkbox" name="show_deleted" id="show_deleted" {{ old('show_deleted') ? 'checked' : '' }} {{ $showDeleted ? 'checked' : '' }}>
                </form>
            </div>
        </div>
        

        <div class="card-body">
            <table class="table table-responsive-sm table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    @if ($showDeleted)
                        <th>Deleted at</th>
                    @endif
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($usersPaginator as $user)
                    <tr class="{{ $user->deleted_at ? 'text-gray-300' : ''}}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                {{ $role->name .  ' | ' }}
                            @endforeach
                        </td>
                        @if($showDeleted)
                            <td>{{ $user->deleted_at }}</td>
                        @endif
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('users.edit', $user) }}">
                                Edit
                            </a>
                            @if($user->deleted_at)
                                <form action="" method="POST" onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
                                    @csrf
                                    <input type="submit" class="btn btn-xs btn-danger" value="Restore">
                                </form>
                            @else
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are your sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $usersPaginator->withQueryString()->links() }}
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
