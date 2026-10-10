@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">Edit {{ $page->slug }} Page Information</h1>
            </div>
        </div>
    </div>

    @php
        $settings = $page ? json_decode($page->data, true) : [];

        $coreValues = $settings['core_values'] ?? [];
        $teamMembers = $settings['team_members'] ?? [];
        $timeline = $settings['timeline'] ?? [];
        $documents = $settings['documents'] ?? [];
    @endphp

    <div class="row">
        <div class="col-xl-12 mx-auto">

            <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="type" value="{{ $page->type }}">

                {{-- ============================================================
                    COMPANY OVERVIEW
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Company Overview</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Title</label>

                                <input
                                    type="text"
                                    name="overview_title"
                                    value="{{ $settings['overview_title'] ?? '' }}"
                                    class="form-control form-control-sm"
                                    placeholder="About Our Company"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Overview Heading</label>

                                <input
                                    type="text"
                                    name="overview_heading"
                                    value="{{ $settings['overview_heading'] ?? '' }}"
                                    class="form-control form-control-sm"
                                    placeholder="Who We Are"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Overview Description</label>

                                <textarea
                                    name="overview_description"
                                    class="form-control aiz-text-editor"
                                    rows="6"
                                    placeholder="Enter company overview..."
                                >{{ $settings['overview_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <label class="col-form-label">Overview Image</label>

                                <div class="input-group" data-toggle="aizuploader" data-type="image">

                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Browse
                                        </div>
                                    </div>

                                    <div class="form-control file-amount form-control-sm">
                                        Choose File
                                    </div>

                                    <input
                                        value="{{ old('overview_image', $settings['overview_image'] ?? '') }}"
                                        type="hidden"
                                        name="overview_image"
                                        class="selected-files"
                                    >

                                </div>

                                <div class="file-preview box sm"></div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    MISSION & VISION
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Mission & Vision</h6>
                    </div>

                    <div class="card-body">

                        {{-- Mission --}}
                        <div class="border-bottom pb-4 mb-4">

                            <h6 class="mb-3">
                                <u>Mission</u>
                            </h6>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label">Mission Title</label>

                                    <input
                                        type="text"
                                        name="mission_title"
                                        value="{{ $settings['mission_title'] ?? 'Our Mission' }}"
                                        class="form-control form-control-sm"
                                    >
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <label class="col-form-label">Mission Description</label>

                                    <textarea
                                        name="mission_description"
                                        class="form-control aiz-text-editor"
                                        rows="5"
                                    >{{ $settings['mission_description'] ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>


                        {{-- Vision --}}
                        <div>

                            <h6 class="mb-3">
                                <u>Vision</u>
                            </h6>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label">Vision Title</label>

                                    <input
                                        type="text"
                                        name="vision_title"
                                        value="{{ $settings['vision_title'] ?? 'Our Vision' }}"
                                        class="form-control form-control-sm"
                                    >
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <label class="col-form-label">Vision Description</label>

                                    <textarea
                                        name="vision_description"
                                        class="form-control aiz-text-editor"
                                        rows="5"
                                    >{{ $settings['vision_description'] ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    CORE VALUES
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Core Values</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Title</label>

                                <input
                                    type="text"
                                    name="core_values_title"
                                    value="{{ $settings['core_values_title'] ?? 'Our Core Values' }}"
                                    class="form-control form-control-sm"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Description</label>

                                <textarea
                                    name="core_values_description"
                                    class="form-control"
                                    rows="3"
                                >{{ $settings['core_values_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="core-values-repeater">

                            <div data-repeater-list="core_values">

                                @forelse($coreValues as $value)

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <label>Value Title</label>

                                                <input
                                                    type="text"
                                                    name="title"
                                                    value="{{ $value['title'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Integrity"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Icon</label>

                                                <input
                                                    type="text"
                                                    name="icon"
                                                    value="{{ $value['icon'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="la la-heart"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Description</label>

                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                >{{ $value['description'] ?? '' }}</textarea>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <label>Value Title</label>
                                                <input
                                                    type="text"
                                                    name="title"
                                                    class="form-control form-control-sm"
                                                    placeholder="Integrity"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Icon</label>
                                                <input
                                                    type="text"
                                                    name="icon"
                                                    class="form-control form-control-sm"
                                                    placeholder="la la-heart"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Description</label>
                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                ></textarea>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @endforelse

                            </div>

                            <button
                                type="button"
                                data-repeater-create
                                class="btn btn-soft-primary btn-sm"
                            >
                                + Add Core Value
                            </button>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    MANAGEMENT & TEAM
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Management & Team</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Title</label>

                                <input
                                    type="text"
                                    name="team_title"
                                    value="{{ $settings['team_title'] ?? 'Management & Team' }}"
                                    class="form-control form-control-sm"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Description</label>

                                <textarea
                                    name="team_description"
                                    class="form-control"
                                    rows="3"
                                >{{ $settings['team_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="team-repeater">

                            <div data-repeater-list="team_members">

                                @forelse($teamMembers as $member)

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <label>Name</label>

                                                <input
                                                    type="text"
                                                    name="name"
                                                    value="{{ $member['name'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="John Smith"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Designation</label>

                                                <input
                                                    type="text"
                                                    name="designation"
                                                    value="{{ $member['designation'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Chief Executive Officer"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Profile Image</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="image"
                                                >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        Choose File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="image"
                                                        value="{{ $member['image'] ?? '' }}"
                                                        class="selected-files"
                                                    >
                                                </div>

                                                <div class="file-preview box sm"></div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                        <div class="row mt-3">

                                            <div class="col-md-6">
                                                <label>Short Description</label>

                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="3"
                                                >{{ $member['description'] ?? '' }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Profile / LinkedIn URL</label>

                                                <input
                                                    type="text"
                                                    name="profile_url"
                                                    value="{{ $member['profile_url'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="https://..."
                                                >
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <label>Name</label>

                                                <input
                                                    type="text"
                                                    name="name"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Designation</label>

                                                <input
                                                    type="text"
                                                    name="designation"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Profile Image</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="image"
                                                >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        Choose File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="image"
                                                        value=""
                                                        class="selected-files"
                                                    >
                                                </div>

                                                <div class="file-preview box sm"></div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                        <div class="row mt-3">

                                            <div class="col-md-6">
                                                <label>Short Description</label>

                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="3"
                                                ></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Profile / LinkedIn URL</label>

                                                <input
                                                    type="text"
                                                    name="profile_url"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                        </div>

                                    </div>

                                @endforelse

                            </div>

                            <button
                                type="button"
                                data-repeater-create
                                class="btn btn-soft-primary btn-sm"
                            >
                                + Add Team Member
                            </button>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    COMPANY TIMELINE & MILESTONES
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Company Timeline & Milestones</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Title</label>

                                <input
                                    type="text"
                                    name="timeline_title"
                                    value="{{ $settings['timeline_title'] ?? 'Our Journey' }}"
                                    class="form-control form-control-sm"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Description</label>

                                <textarea
                                    name="timeline_description"
                                    class="form-control"
                                    rows="3"
                                >{{ $settings['timeline_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="timeline-repeater">

                            <div data-repeater-list="timeline">

                                @forelse($timeline as $item)

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-2">
                                                <label>Year / Date</label>

                                                <input
                                                    type="text"
                                                    name="year"
                                                    value="{{ $item['year'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="2026"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Milestone Title</label>

                                                <input
                                                    type="text"
                                                    name="title"
                                                    value="{{ $item['title'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                            <div class="col-md-5">
                                                <label>Description</label>

                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                >{{ $item['description'] ?? '' }}</textarea>
                                            </div>

                                            <div class="col-md-1">
                                                <label>Image</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="image"
                                                >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="image"
                                                        value="{{ $item['image'] ?? '' }}"
                                                        class="selected-files"
                                                    >
                                                </div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-2">
                                                <label>Year / Date</label>
                                                <input
                                                    type="text"
                                                    name="year"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Milestone Title</label>
                                                <input
                                                    type="text"
                                                    name="title"
                                                    class="form-control form-control-sm"
                                                >
                                            </div>

                                            <div class="col-md-5">
                                                <label>Description</label>
                                                <textarea
                                                    name="description"
                                                    class="form-control form-control-sm"
                                                    rows="2"
                                                ></textarea>
                                            </div>

                                            <div class="col-md-1">
                                                <label>Image</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="image"
                                                >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="image"
                                                        value=""
                                                        class="selected-files"
                                                    >
                                                </div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @endforelse

                            </div>

                            <button
                                type="button"
                                data-repeater-create
                                class="btn btn-soft-primary btn-sm"
                            >
                                + Add Milestone
                            </button>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    IMPORTANT DOCUMENTS
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Important Documents</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Title</label>

                                <input
                                    type="text"
                                    name="documents_title"
                                    value="{{ $settings['documents_title'] ?? 'Important Documents' }}"
                                    class="form-control form-control-sm"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">Section Description</label>

                                <textarea
                                    name="documents_description"
                                    class="form-control"
                                    rows="3"
                                >{{ $settings['documents_description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="documents-repeater">

                            <div data-repeater-list="documents">

                                @forelse($documents as $document)

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>Document Title</label>

                                                <input
                                                    type="text"
                                                    name="title"
                                                    value="{{ $document['title'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Company Profile"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Document Type</label>

                                                <input
                                                    type="text"
                                                    name="type"
                                                    value="{{ $document['type'] ?? '' }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="PDF"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Document File</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="document"
                                                >

                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        Choose File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="file"
                                                        value="{{ $document['file'] ?? '' }}"
                                                        class="selected-files"
                                                    >

                                                </div>

                                                <div class="file-preview box sm"></div>
                                            </div>

                                            <div class="col-md-1">
                                                <label>Status</label>

                                                <select name="status" class="form-control form-control-sm">
                                                    <option
                                                        value="1"
                                                        {{ ($document['status'] ?? 1) == 1 ? 'selected' : '' }}
                                                    >
                                                        Active
                                                    </option>

                                                    <option
                                                        value="0"
                                                        {{ ($document['status'] ?? 1) == 0 ? 'selected' : '' }}
                                                    >
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div data-repeater-item class="border rounded p-3 mb-3">

                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>Document Title</label>

                                                <input
                                                    type="text"
                                                    name="title"
                                                    class="form-control form-control-sm"
                                                    placeholder="Company Profile"
                                                >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Document Type</label>

                                                <input
                                                    type="text"
                                                    name="type"
                                                    class="form-control form-control-sm"
                                                    placeholder="PDF"
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label>Document File</label>

                                                <div
                                                    class="input-group"
                                                    data-toggle="aizuploader"
                                                    data-type="document"
                                                >

                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary">
                                                            Browse
                                                        </div>
                                                    </div>

                                                    <div class="form-control file-amount">
                                                        Choose File
                                                    </div>

                                                    <input
                                                        type="hidden"
                                                        name="file"
                                                        value=""
                                                        class="selected-files"
                                                    >

                                                </div>

                                                <div class="file-preview box sm"></div>
                                            </div>

                                            <div class="col-md-1">
                                                <label>Status</label>

                                                <select name="status" class="form-control form-control-sm">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-center">
                                                <button
                                                    type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    ×
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                @endforelse

                            </div>

                            <button
                                type="button"
                                data-repeater-create
                                class="btn btn-soft-primary btn-sm"
                            >
                                + Add Document
                            </button>

                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    SEO
                ============================================================= --}}
                @include('backend.inc.page_seo', ['settings' => $settings])


                {{-- ============================================================
                    UPDATE
                ============================================================= --}}
                <div class="text-right mb-4">
                    <button type="submit" class="btn btn-info btn-sm">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection


@section('script')

    {{-- jQuery Repeater --}}
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-..."
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>

    <script>
        $(document).ready(function () {

            var lang = '{{ $lang }}';

            if (lang == 'ae') {
                setEditorDirection(true);
            } else {
                setEditorDirection(false);
            }

            function setEditorDirection(isRtl) {
                const editor = $('.aiz-text-editor')
                    .next('.note-editor')
                    .find('.note-editable');

                editor.attr('dir', isRtl ? 'rtl' : 'ltr');
                editor.css(
                    'text-align',
                    isRtl ? 'right' : 'left'
                );
            }


            /*
             * Initialize Repeater
             */
            function initializeRepeater(selector) {

                $(selector).repeater({

                    initEmpty: false,

                    show: function () {
                        $(this).slideDown();

                        /*
                         * Reinitialize AIZ uploader for newly
                         * created repeater items.
                         */
                        if (
                            typeof AIZ !== 'undefined' &&
                            typeof AIZ.uploader === 'function'
                        ) {
                            AIZ.uploader();
                        }
                    },

                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    }

                });

            }


            /*
             * Core Values
             */
            initializeRepeater('.core-values-repeater');


            /*
             * Management & Team
             */
            initializeRepeater('.team-repeater');


            /*
             * Company Timeline
             */
            initializeRepeater('.timeline-repeater');


            /*
             * Important Documents
             */
            initializeRepeater('.documents-repeater');

        });
    </script>

@endsection
