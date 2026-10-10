@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <h1 class="h3">{{ __('Create Job Vacancy') }}</h1>
</div>

<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('job-vacancies.store') }}">
            @csrf

            @include('backend.job_vacancies.form')

            <button type="submit" class="btn btn-primary">
                {{ __('Create Vacancy') }}
            </button>

            <a href="{{ route('job-vacancies.index') }}"
               class="btn btn-light">
                {{ __('Cancel') }}
            </a>
        </form>
    </div>
</div>
@endsection
