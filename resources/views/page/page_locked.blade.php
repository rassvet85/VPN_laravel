@extends('layouts.masternonauth')

@section('title', 'Locked Screen')

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
                    <a href="{{url('page/page_register')}}" class="btn-link text-white ml-auto">
                        Create Account
                    </a>
                </div>
            </div>
            <div class="d-flex flex-1" style="background: url(/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0 text-white d-flex align-items-center justify-content-center">
                    <form id="js-login" role="form" class="text-center text-white mb-5 pb-5" action="/#">
                        <div class="py-3">
                            <img src="{{ URL::asset('/img/demo/avatars/avatar-admin-lg.png') }}" class="img-responsive rounded-circle img-thumbnail" alt="thumbnail">
                        </div>
                        <div class="form-group">
                            <h3>
                                Dr. Codex Lantern
                                <small>
                                    drlantern@gotbootstrap.com
                                </small>
                            </h3>
                            <p class="text-white opacity-50">Enter password to unlock screen</p>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <button class="btn btn-success shadow-0" type="button" id="button-addon5"><i class="fal fa-key"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{url('/page/page_login_alt')}}" class="text-white opacity-90">Not Dr. Codex Lantern ?</a>
                        </div>
                    </form>
                    @include('layouts/partials/footer-sm')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN Color profile -->
<!-- this area is hidden and will not be seen on screens or screen readers -->
@include('layouts/partials/color-profile')
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
