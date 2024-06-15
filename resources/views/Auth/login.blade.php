{{-- <x-mainLayout page="Login">
    <div class="bg-gray-300 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <form method="POST" action="{{ route('signin') }}">
            @csrf()
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
                <button type="submit">SignIn</button>
            </div>

            <div class="mt-4 hover:text-blue-700">
                <a href="{{ route('users.create') }}">Don't Have An Account? Create One</a>
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
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('signin') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="mt-4 hover:text-blue-700">
                        <a href="{{ route('users.create') }}">Don't Have An Account? Create One</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection