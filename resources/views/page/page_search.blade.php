@extends('layouts.master')

@section('title', 'Search - Page Views')

@section('headerStyle')
<link rel="stylesheet" media="screen, print" href="{{ URL::asset('css/fa-solid.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ URL::asset('css/fa-brands.css') }}">
@stop

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <!-- Page heading removed for composed layout -->
    <div class="px-3 px-sm-5 pt-4">
        <h1 class="mb-4">
            160 Results for "SmartAdmin Laravel"
            <small class="mb-3">
                Request time (0.23 seconds)
            </small>
        </h1>
        <div class="input-group input-group-lg mb-5 shadow-1 rounded">
            <input type="text" class="form-control shadow-inset-2" id="filter-icon" aria-label="type 2 or more letters" placeholder="Search anything..." value="SmartAdmin Laravel responsive webapp">
            <div class="input-group-append">
                <button class="btn btn-primary hidden-sm-down" type="button"><i class="fal fa-search mr-lg-2"></i><span class="hidden-md-down">Search</span></button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Data</a>
                    <a class="dropdown-item" href="#">Images</a>
                    <a class="dropdown-item" href="#">Users</a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item active" href="#">Everything</a>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

@section('footerScript')
<script>
    initApp.pushSettings("layout-composed", false);
</script>
@stop
