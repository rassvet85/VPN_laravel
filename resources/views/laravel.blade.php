@extends('layouts.master')

@section('title', 'Welcome - Laravel')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    @component('common-components.breadcrumb')
    @slot('item1') Welcome @endslot
    @slot('item2') SmartAdmin for Laravel @endslot
    @endcomponent
</main>
@stop
