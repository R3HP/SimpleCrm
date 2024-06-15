{{-- <x-mainLayout page="SignUp">
    <div class="bg-gray-300 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf() 
            <div class="mb-4">
                <label class="inline-block text-lg mb-2" for="name"> Name : </label>
                <input class="border border-gray-200 rounded p-2 w-full" type="text" id="name" value="{{ old('name') }}" name="name" /> 
                <x-input-error-label input-name="name" />
            </div>
            <div class="mb-4">
                <label class="inline-block text-lg mb-2" for="email"> Email : </label>
                <input class="border border-gray-200 rounded p-2 w-full" type="email" id="email" value="{{ old('email') }}" name="email" /> 
                <x-input-error-label input-name="email" />
            </div>
    
            <div class="mb-6">
                <label class="inline-block text-lg mb-2" for="password"> Password : </label>
                <input class="border border-gray-200 rounded p-2 w-full" type="text" id="password" value="{{ old('password') }}" name="password" /> 
                <x-input-error-label input-name="password" />
            </div>

            <div class="bg-blue-600 text-white rounded py-2 px-4 hover:bg-blue-800 text-center">
                <button type="submit">SignUp</button>
            </div>

            <div class="mt-4 hover:text-blue-700">
                <a href="{{ route('login') }}">Already Have An Account? SignIn</a>
            </div>
        </form>
    </div>
</x-mainLayout> --}}


@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-4 hover:text-blue-700">
                        <a href="{{ route('login') }}">Already Have An Account? SignIn</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection