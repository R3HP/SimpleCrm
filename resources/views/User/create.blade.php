@extends('../layouts/app')

@section('content')

    <div class="card">
        <div class="card-header">Create user</div>

        <div class="card-body">
            <form action="{{ route('users.store') }}">
                @csrf
                {{-- <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div> --}}
                <div class="form-group">
                    <label class="required" for="fist_name">First Name</label>
                    <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('first_name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>
                <div class="form-group">
                    <label class="required" for="last_name">Name</label>
                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                    @if($errors->has('last_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('last_name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label class="required" for="email">Email</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email') }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address') }}">
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone number</label>
                    <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                    @if($errors->has('phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <label for="phone_number">Password</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" value="{{ old('password') }}">
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block"> </span>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection