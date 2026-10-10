@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <h1 class="h3">{{ __('Review Job Application') }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <h4>{{ $jobApplication->candidate_name }}</h4>

        <p>
            <strong>{{ __('Vacancy:') }}</strong>
            {{ $jobApplication->vacancy?->title ?? '—' }}
        </p>

        <p>
            <strong>{{ __('Email:') }}</strong>
            <a href="mailto:{{ $jobApplication->email }}">
                {{ $jobApplication->email }}
            </a>
        </p>

        <p>
            <strong>{{ __('Phone:') }}</strong>
            {{ $jobApplication->phone ?: '—' }}
        </p>

        <h6>{{ __('Cover Letter') }}</h6>
        <div class="mb-4">
            {{ $jobApplication->cover_letter ?: '—' }}
        </div>

        <a
            href="{{ route('job-applications.cv', $jobApplication) }}"
            class="btn btn-info mb-4"
        >
            <i class="las la-download"></i>
            {{ __('Download CV') }}
        </a>

        <hr>

        <form
            method="POST"
            action="{{ route('job-applications.update', $jobApplication) }}"
        >
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>{{ __('Application Status') }}</label>
                <select name="status" class="form-control" required>
                    @foreach (['submitted', 'under_review', 'shortlisted', 'rejected', 'hired'] as $status)
                        <option
                            value="{{ $status }}"
                            @selected(old('status', $jobApplication->status) === $status)
                        >
                            {{ __(ucwords(str_replace('_', ' ', $status))) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>{{ __('Internal Notes') }}</label>
                <textarea
                    name="admin_notes"
                    class="form-control"
                    rows="5"
                >{{ old('admin_notes', $jobApplication->admin_notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Update Application') }}
            </button>

            <a href="{{ route('job-applications.index') }}"
               class="btn btn-light">
                {{ __('Back') }}
            </a>
        </form>
    </div>
</div>
@endsection
