@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">

    <div class="row align-items-center">

        <div class="col-md-6">
            <h1 class="h3">Edit Service</h1>
        </div>

        <div class="col-md-6 text-md-right">
            <a href="{{ route('service.index') }}"
               class="btn btn-light">
                <i class="las la-arrow-left"></i>
                Back to Services
            </a>
        </div>

    </div>

</div>

<form
    action="{{ route('service.update', $service->id) }}"
    method="POST"
    enctype="multipart/form-data"
>

    @csrf
    @method('PUT')

    @include('backend.services._form')

</form>

@endsection
