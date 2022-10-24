@extends('layouts.master')

@section('title', 'Contacts - Page Views')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    @component('common-components.breadcrumb')
    @slot('item1') Page Views @endslot
    @slot('item2') Error Pages @endslot
    @slot('item3') Server Error @endslot
    @endcomponent
    <div class="subheader"></div>
    <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="page-error color-fusion-500">
            ERROR <span class="text-gradient">404</span>
            <small class="fw-500">
                Something <u>went</u> wrong!
            </small>
        </h1>
        <h3 class="fw-500 mb-5">
            You have experienced a technical error. We apologize.
        </h3>
        <h4>
            We are working hard to correct this issue. Please wait a few moments and try your search again.
            <br>In the meantime, check out whats new on SmartAdmin Laravel:
        </h4>
    </div>
</main>
@stop
