@extends('layouts.app')

@section('content')  
        <div class="card">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                <form action="{{ route('auth.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="old_password">Old password</label>
                        <input class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" type="password" name="old_password" id="old_password" required>
                        @if($errors->has('old_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('old_password') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="new_password">New password</label>
                        <input class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" type="password" name="new_password" id="new_password" required>
                        @if($errors->has('new_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="new_password_confirmation">Confirm new password</label>
                        <input class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                        @if($errors->has('new_password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password_confirmation') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
@endsection