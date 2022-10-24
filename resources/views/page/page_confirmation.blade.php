@extends('layouts.masternonauth')

@section('title', 'Login')

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
                    <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                        Already a member?
                    </span>
                    <a href="/page/page_login" class="btn-link text-white ml-auto ml-sm-0">
                        Secure Login
                    </a>
                </div>
            </div>
            <div class="flex-1" style="background: url(/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                Thank you registrering! Please check your email.
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-70 hidden-sm-down">
                                    We’ve sent a message to <strong>drlantern@gotbootstrap.com</strong> with a link to activate your account.
                                </small>
                            </h2>
                        </div>
                        <div class="col-xl-6 ml-auto mr-auto">
                            <div class="card p-4 rounded-plus bg-faded">
                                <div class="alert alert-primary text-dark" role="alert">
                                    <strong>Heads Up!</strong> Due to server maintenance from 9:30GTA to 12GTA, the verification emails could be delayed by up to 10 minutes.
                                </div>
                                <a href="javascript:void(0);" class="h4">
                                    <i class="fal fa-chevron-right mr-2"></i> Didn’t get an email?
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts/partials/footer-sm')
            </div>
        </div>
    </div>
</div>
<!-- BEGIN Color profile -->
<!-- this area is hidden and will not be seen on screens or screen readers -->
@include('layouts/partials/color-profile')
@stop
