@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar mt-2 mb-4 d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0">{{ __('Job Vacancies') }}</h1>

    <a href="{{ route('job-vacancies.create') }}"
       class="btn btn-primary">
        <i class="las la-plus"></i> {{ __('Add Vacancy') }}
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="form-row">
                <div class="col-md-6 mb-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search vacancies') }}"
                    >
                </div>

                <div class="col-md-3 mb-2">
                    <select name="status" class="form-control">
                        <option value="">{{ __('All statuses') }}</option>
                        @foreach (['draft', 'published', 'closed'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ __(ucfirst($status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <button class="btn btn-info">{{ __('Filter') }}</button>
                    <a href="{{ route('job-vacancies.index') }}"
                       class="btn btn-light">{{ __('Reset') }}</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Job Title') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Applications') }}</th>
                        <th>{{ __('Deadline') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($vacancies as $vacancy)
                        <tr>
                            <td>{{ $vacancy->title }}</td>
                            <td>{{ $vacancy->company_name ?: '—' }}</td>
                            <td>{{ $vacancy->location ?: '—' }}</td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ __(ucfirst($vacancy->status)) }}
                                </span>
                            </td>
                            <td>{{ $vacancy->applications_count }}</td>
                            <td>
                                {{ $vacancy->application_deadline?->format('d M Y') ?? '—' }}
                            </td>
                            <td class="text-right">
                                <a
                                    href="{{ route('job-vacancies.edit', $vacancy) }}"
                                    class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    title="{{ __('Edit') }}"
                                >
                                    <i class="las la-edit"></i>
                                </a>

                                <form
                                    action="{{ route('job-vacancies.destroy', $vacancy) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('{{ __('Delete this vacancy and its application records?') }}')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                        title="{{ __('Delete') }}"
                                    >
                                        <i class="las la-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                {{ __('No vacancies found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $vacancies->links() }}
        </div>
    </div>
</div>
@endsection
