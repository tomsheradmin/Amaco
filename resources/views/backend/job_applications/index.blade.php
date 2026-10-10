@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <h1 class="h3">{{ __('Job Applications') }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="form-row">
                <div class="col-md-6 mb-2">
                    <input
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search candidates or vacancies') }}"
                    >
                </div>

                <div class="col-md-3 mb-2">
                    <select name="status" class="form-control">
                        <option value="">{{ __('All statuses') }}</option>
                        @foreach (['submitted', 'under_review', 'shortlisted', 'rejected', 'hired'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ __(ucwords(str_replace('_', ' ', $status))) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <button class="btn btn-info">{{ __('Filter') }}</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table aiz-table">
                <thead>
                    <tr>
                        <th>{{ __('Candidate') }}</th>
                        <th>{{ __('Vacancy') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Submitted') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr>
                            <td>{{ $application->candidate_name }}</td>
                            <td>{{ $application->vacancy?->title ?? '—' }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ __(ucwords(str_replace('_', ' ', $application->status))) }}</td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                <a
                                    href="{{ route('job-applications.show', $application) }}"
                                    class="btn btn-soft-primary btn-sm"
                                >
                                    {{ __('Review') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                {{ __('No applications found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $applications->links() }}
    </div>
</div>
@endsection
