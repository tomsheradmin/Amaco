@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Subsidiary Companies</h1>

        <a href="{{ route('subsidiaries.create') }}" class="btn btn-primary">
            <i class="las la-plus"></i> Add Subsidiary
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th>Enquiries</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td>{{ $companies->firstItem() + $loop->index }}</td>
                            <td>
                                <strong>{{ $company->name }}</strong>
                                <div class="text-muted small">{{ $company->slug }}</div>
                            </td>
                            <td>
                                @if($company->website_url)
                                    <a href="{{ $company->website_url }}"
                                       target="_blank" rel="noopener noreferrer">
                                        Official website
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                {{ ucfirst($company->status) }}
                            </td>
                            <td>{{ $company->enquiries_count }}</td>
                            <td>
                                <a href="{{ route('subsidiaries.edit', $company) }}"
                                   class="btn btn-sm btn-info">Edit</a>

                                @if($company->status === 'published')
                                    <a href="{{ route('subsidiaries.show', $company->slug) }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="btn btn-sm btn-secondary">
                                        View Page
                                    </a>
                                @endif

                                <form action="{{ route('subsidiaries.destroy', $company) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this subsidiary?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No subsidiary companies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $companies->links() }}
        </div>
    </div>
</div>
@endsection
