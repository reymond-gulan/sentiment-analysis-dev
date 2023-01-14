@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            @if(session('deactivated'))
            <div class="alert alert-danger small">
                <center>
                <h4><b>Unauthorized Access!</b></h4>
                It seems like your account was deactivated. 
                <br />
                Please contact the administrator.
                </center>
            </div>
            @endif
                <div class="card-body rounded-5 pb-5 p-2 small shadow-lg bg-white"> <!---  -->
                <center>
                    <h3 class="mb-5 border-bottom border-2 py-5 border-secondary color-theme">
                        <b><i class="fa fa-lock"></i> ACCOUNT LOGIN</b>
                    </h3>
                </center>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container px-3">
                        <div class="form-floating mb-3">
                            <input id="email" type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}"
                                    placeholder="Email Address" 
                                    required autocomplete="email" autofocus>
                            <label for="floatingInput">Email Address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" placeholder="Password"
                                required autocomplete="current-password">
                            <label for="floatingInput">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <!-- <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="row mb-3 px-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0 px-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary px-5">
                                    {{ __('LOGIN') }}
                                </button>
                                {{----}}
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                
                            </div>
                        </div>
                    </form>
                    
                </div>
        </div>
    </div>
</div>
@endsection
