
@extends('backend.layouts.app')

@section('content')
@php
    $settings = $page ? (json_decode($page->data, true) ?? []) : [];
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">
                Edit {{ $page->slug ?: 'Service Details Page Settings' }}
            </h1>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <strong>Note:</strong>
    These settings apply to all service detail pages. Individual service names, descriptions, images, galleries and SEO should be managed from the Services module.
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Common Banner Settings</h5>
    </div>

    <div class="card-body">
        <form
            action="{{ route('business_settings.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <input type="hidden" name="type" value="{{ $page->type }}">

            {{-- Banner Image --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Image
                </label>

                <div class="col-md-9">
                    <div
                        class="input-group"
                        data-toggle="aizuploader"
                        data-type="image"
                    >
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                Browse
                            </div>
                        </div>

                        <div class="form-control file-amount">
                            Choose Image
                        </div>

                        <input
                            type="hidden"
                            name="banner_image"
                            class="selected-files"
                            value="{{ $settings['banner_image'] ?? '' }}"
                        >
                    </div>

                    <div class="file-preview box sm"></div>

                    <small class="text-muted">
                        Select the common banner image displayed on service detail pages.
                    </small>
                </div>
            </div>

            {{-- Banner Heading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Heading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="banner_heading"
                        value="{{ $settings['banner_heading'] ?? '' }}"
                        placeholder="Enter banner heading"
                    >
                </div>
            </div>

            {{-- Banner Subheading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Subheading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="banner_subheading"
                        value="{{ $settings['banner_subheading'] ?? '' }}"
                        placeholder="Enter banner subheading"
                    >
                </div>
            </div>

            {{-- Banner Description --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Description
                </label>

                <div class="col-md-9">
                    <textarea
                        class="form-control form-control-sm"
                        name="banner_description"
                        rows="3"
                        placeholder="Enter an optional banner description"
                    >{{ $settings['banner_description'] ?? '' }}</textarea>

                    <small class="text-muted">
                        Optional text displayed below the banner heading.
                    </small>
                </div>
            </div>

            <hr>

            {{-- Shared Content Section --}}
            <div class="card-header px-0">
                <h5 class="mb-0">
                    Common Content Section
                </h5>
            </div>

            <div class="form-group row mt-3">
                <label class="col-md-3 col-from-label">
                    Section Heading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="section_heading"
                        value="{{ $settings['section_heading'] ?? '' }}"
                        placeholder="Enter common section heading"
                    >

                    <small class="text-muted">
                        Optional heading shared across service detail pages.
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Section Introduction
                </label>

                <div class="col-md-9">
                    <textarea
                        class="aiz-text-editor"
                        name="section_introduction"
                        placeholder="Enter a common section introduction"
                    >{{ $settings['section_introduction'] ?? '' }}</textarea>

                    <small class="text-muted">
                        Optional introductory content shared across service detail pages. The main service description comes from the individual service record.
                    </small>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        if (typeof AIZ !== 'undefined' && AIZ.uploader) {
            AIZ.uploader();
        }

        if ($('.aiz-text-editor').length && $.fn.summernote) {
            $('.aiz-text-editor').each(function () {
                if (!$(this).next().hasClass('note-editor')) {
                    $(this).summernote({
                        height: 150,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link']],
                            ['view', ['fullscreen', 'codeview']]
                        ]
                    });
                }
            });
        }
    });
</script>
@endsection
