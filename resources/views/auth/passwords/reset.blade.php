@extends('layouts.app')

@section('title', 'Reset Password')

@section('headerStyle')
<link rel="stylesheet" media="screen, print" href="{{ URL::asset('css/fa-brands.css') }}">
@stop

@section('content')
<div class="page-wrapper">
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="{{ URL::asset('/img/logo.png') }}" alt="SmartAdmin Laravel" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">SmartAdmin Laravel</span>
                        </a>
                    </div>
                    <a href="/register" class="btn-link text-white ml-auto">
                        Sign up
                    </a>
                </div>
            </div>
            <div class="flex-1" style="background: url{{ URL::asset('/img/svg/pattern-1.svg') }} no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 hidden-sm-down">
                            <h2 class="fs-xxl fw-500 mt-4 text-white">
                                The simplest UI toolkit for developers &amp; programmers
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                                    Presenting you with the next level of innovative UX design and engineering. The most modular toolkit available with over 600+ layout permutations. Experience the simplicity of SmartAdmin, everywhere you go!
                                </small>
                            </h2>
                            <a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a>
                            <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                                <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                                    Find us on social media
                                </div>
                                <div class="d-flex flex-row opacity-70">
                                    <a href="#" class="mr-2 fs-xxl text-white">
                                        <i class="fab fa-facebook-square"></i>
                                    </a>
                                    <a href="#" class="mr-2 fs-xxl text-white">
                                        <i class="fab fa-twitter-square"></i>
                                    </a>
                                    <a href="#" class="mr-2 fs-xxl text-white">
                                        <i class="fab fa-google-plus-square"></i>
                                    </a>
                                    <a href="#" class="mr-2 fs-xxl text-white">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">

                            <div class="card p-4 rounded-plus bg-faded">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label class="form-label" for="username">Email</label>

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="help-block">Email Address</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="username">Password</label>

                                        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="help-block">Password</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="userpassword">Confirm Password</label>
                                        <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <div class="help-block">Confirm Password</div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-lg-12 pr-lg-1 my-2">
                                            <button type="submit" class="btn btn-info btn-block btn-lg">
                                                {{ __('Reset Password') }}
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('layouts/partials/footer-sm')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footerScript')
<script>
    $("#js-login-btn").click(function(event) {
        // Fetch form to apply custom Bootstrap validation
        var form = $("#js-login")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.addClass('was-validated');
        // Perform ajax submit here...
    });
</script>
@stop