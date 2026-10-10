@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Add Subsidiary Company</h1>

    @include('backend.subsidiaries.form', [
        'company' => $company,
        'action' => route('subsidiaries.store'),
        'httpMethod' => 'POST',
    ])
</div>
@endsection
