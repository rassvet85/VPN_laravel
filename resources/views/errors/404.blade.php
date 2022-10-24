@extends('errors::minimal')

@section('title', __('Not Found'))

<div class="flex-center position-ref full-height">
    <div class="code">
        404 </div>

    <div class="message" style="padding: 10px;">
        Not Found
    </div>
    <div style="position: absolute;top: calc(50% + 40px);">
        Back to the <a href="{{url('/')}}"> Home</a> page.
    </div>
</div>