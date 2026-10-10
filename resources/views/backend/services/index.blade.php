@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">Services</h1>
        </div>

        <div class="col-md-6 text-md-right">
            <a href="{{ route('service.create') }}"
               class="btn btn-primary">
                <i class="las la-plus"></i>
                Add New Service
            </a>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h5 class="mb-0 h6">All Services</h5>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($services->count())

            <div class="table-responsive">

                <table class="table aiz-table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Subsidiary</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($services as $key => $service)

                            <tr>

                                <td>
                                    {{ ($services->currentPage() - 1) * $services->perPage() + $key + 1 }}
                                </td>

                                <td>

                                    <div class="d-flex align-items-center">

                                        @if($service->image)
                                            <img
                                                src="{{ uploaded_asset($service->image) }}"
                                                class="size-50px rounded"
                                                alt="{{ $service->name }}"
                                            >
                                        @else
                                            <div class="size-50px bg-light rounded d-flex align-items-center justify-content-center">
                                                <i class="las la-image la-2x text-muted"></i>
                                            </div>
                                        @endif

                                        <div class="ml-3">

                                            <div class="font-weight-bold">
                                                {{ $service->name }}
                                            </div>

                                            <small class="text-muted">
                                                /services/{{ $service->slug }}
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    {{ $service->subsidiary?->name ?? '—' }}
                                </td>

                                <td>
                                    {{ $service->sort_order }}
                                </td>

                                <td>

                                    @if($service->status)
                                        <span class="badge badge-inline badge-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-inline badge-danger">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                <td>
                                    {{ $service->created_at?->format('d M Y') }}
                                </td>

                                <td class="text-right">

                                    <a
                                        href="{{ route('service.edit', $service->id) }}"
                                        class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        title="Edit"
                                    >
                                        <i class="las la-edit"></i>
                                    </a>

                                    <a
                                        href="{{ route('service.show', $service->slug) }}"
                                        target="_blank"
                                        class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        title="View"
                                    >
                                        <i class="las la-eye"></i>
                                    </a>

                                    <form
                                        action="{{ route('service.destroy', $service->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            title="Delete"
                                        >
                                            <i class="las la-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="aiz-pagination mt-4">
                {{ $services->links() }}
            </div>

        @else

            <div class="text-center py-5">

                <div class="mb-3">
                    <i class="las la-concierge-bell la-4x text-muted"></i>
                </div>

                <h5>No services found</h5>

                <p class="text-muted">
                    Start by adding your first service.
                </p>

                <a href="{{ route('service.create') }}"
                   class="btn btn-primary">
                    Add New Service
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
