@extends('layouts.masternonauth')

@section('title', 'Login')

@section('headerStyle')
<link rel="stylesheet" media="screen, print" href="{{ URL::asset('css/page-login-alt.css')}}">
@stop

@section('content')

<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="{{ URL::asset('/img/logo.png') }}" alt="SmartAdmin Laravel" aria-roledescription="logo">
            <span class="page-logo-text mr-1">SmartAdmin Laravel</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <form action="{{url('/dashboard/index')}}">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="email" id="username" class="form-control" placeholder="your id or email" value="drlantern@gotbootstrap.com">
                <span class="help-block">
                    Your unique username to app
                </span>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="password" value="password123">
                <span class="help-block">
                    Your password
                </span>
            </div>
            <div class="form-group text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="rememberme">
                    <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
                </div>
            </div>
            <button type="submit" class="btn btn-default float-right">Secure login</button>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        <a href="{{url('/page/page_login')}}"><strong>Recover Password</strong></a> | <a href="{{url('/page/page_register')}}"><strong>Register Account</strong></a>
    </div>
</div>
<div class="login-footer p-2">
    <div class="row">
        <div class="col col-sm-12 text-center">
            <i><strong>System Message:</strong> You were logged out from 198.164.246.1 on Saturday, March, 2017 at 10.56AM</i>
        </div>
    </div>
</div>
<video poster="{{ URL::asset('/img/backgrounds/clouds.png') }}" id="bgvid" playsinline autoplay muted loop>
    <source src="{{ URL::asset('media/video/cc.webm') }}" type="video/webm">
    <source src="{{ URL::asset('media/video/cc.mp4') }}" type="video/mp4">
</video>
<!-- BEGIN Color profile -->
<!-- this area is hidden and will not be seen on screens or screen readers -->
@include('layouts/partials/color-profile')
@stop
