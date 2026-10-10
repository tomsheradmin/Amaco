@extends('backend.layouts.app')

@section('content')
@php
    $settings = $page
        ? (json_decode($page->data, true) ?? [])
        : [];
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">
                Edit {{ $page->slug ?: 'Subsidiary Landing Page' }}
            </h1>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <strong>Note:</strong>
    These settings control the shared layout and content across all
    subsidiary landing pages. Individual subsidiary names, descriptions,
    images, contact details, and SEO should be managed through the
    Subsidiary module.
</div>

<form
    action="{{ route('business_settings.update') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <input type="hidden" name="type" value="{{ $page->type }}">

    {{-- ========================================================= --}}
    {{-- BANNER SETTINGS --}}
    {{-- ========================================================= --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Common Banner Settings</h5>
        </div>

        <div class="card-body">

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
                        Shared banner background for subsidiary landing pages.
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

            {{-- Banner CTA Button Text --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Button Text
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="banner_button_text"
                        value="{{ $settings['banner_button_text'] ?? '' }}"
                        placeholder="e.g. Explore Subsidiaries"
                    >

                    <small class="text-muted">
                        Leave empty if the banner should not display a button.
                    </small>
                </div>
            </div>

            {{-- Banner CTA URL --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Banner Button URL
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="banner_button_url"
                        value="{{ $settings['banner_button_url'] ?? '' }}"
                        placeholder="Enter URL or route path"
                    >
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- COMMON CONTENT SETTINGS --}}
    {{-- ========================================================= --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Common Content Section</h5>
        </div>

        <div class="card-body">

            {{-- Enable Content Section --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Display Content Section
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_content_section"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_content_section"
                            value="1"
                            {{ ($settings['show_content_section'] ?? 1) ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>

                    <small class="text-muted d-block mt-2">
                        Enable or disable the shared introductory section.
                    </small>
                </div>
            </div>

            {{-- Section Heading --}}
            <div class="form-group row">
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
                </div>
            </div>

            {{-- Section Introduction --}}
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
                        Optional rich-text content shared across subsidiaries.
                        The individual subsidiary description remains separate.
                    </small>
                </div>
            </div>

            {{-- Section Image --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Section Image
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
                            name="section_image"
                            class="selected-files"
                            value="{{ $settings['section_image'] ?? '' }}"
                        >
                    </div>

                    <div class="file-preview box sm"></div>

                    <small class="text-muted">
                        Optional image for the shared content section.
                    </small>
                </div>
            </div>

            {{-- Section Image Position --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Image Position
                </label>

                <div class="col-md-9">
                    <select
                        name="section_image_position"
                        class="form-control form-control-sm"
                    >
                        <option
                            value="left"
                            {{ ($settings['section_image_position'] ?? 'left') == 'left' ? 'selected' : '' }}
                        >
                            Left
                        </option>

                        <option
                            value="right"
                            {{ ($settings['section_image_position'] ?? 'left') == 'right' ? 'selected' : '' }}
                        >
                            Right
                        </option>
                    </select>

                    <small class="text-muted">
                        Controls the image position when the frontend template supports it.
                    </small>
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- CALL TO ACTION SETTINGS --}}
    {{-- ========================================================= --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Call to Action Section</h5>
        </div>

        <div class="card-body">

            {{-- Enable CTA --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Display CTA Section
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_cta_section"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_cta_section"
                            value="1"
                            {{ ($settings['show_cta_section'] ?? 0) ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>

                    <small class="text-muted d-block mt-2">
                        Enable a shared call-to-action section on subsidiary pages.
                    </small>
                </div>
            </div>

            {{-- CTA Heading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    CTA Heading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="cta_heading"
                        value="{{ $settings['cta_heading'] ?? '' }}"
                        placeholder="e.g. Let's Work Together"
                    >
                </div>
            </div>

            {{-- CTA Description --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    CTA Description
                </label>

                <div class="col-md-9">
                    <textarea
                        class="form-control form-control-sm"
                        name="cta_description"
                        rows="3"
                        placeholder="Enter a short call-to-action description"
                    >{{ $settings['cta_description'] ?? '' }}</textarea>
                </div>
            </div>

            {{-- CTA Button Text --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    CTA Button Text
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="cta_button_text"
                        value="{{ $settings['cta_button_text'] ?? '' }}"
                        placeholder="e.g. Contact Us"
                    >
                </div>
            </div>

            {{-- CTA Button URL --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    CTA Button URL
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        name="cta_button_url"
                        value="{{ $settings['cta_button_url'] ?? '' }}"
                        placeholder="Enter URL or route path"
                    >
                </div>
            </div>

            {{-- CTA Background Image --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    CTA Background Image
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
                            name="cta_background_image"
                            class="selected-files"
                            value="{{ $settings['cta_background_image'] ?? '' }}"
                        >
                    </div>

                    <div class="file-preview box sm"></div>

                    <small class="text-muted">
                        Optional background image for the CTA section.
                    </small>
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- SAVE SETTINGS --}}
    {{-- ========================================================= --}}

    <div class="card">
        <div class="card-body">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="las la-save"></i>
                    Save Settings
                </button>
            </div>
        </div>
    </div>

</form>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Initialize the AIZ image uploader.
        if (typeof AIZ !== 'undefined' && AIZ.uploader) {
            AIZ.uploader();
        }

        // Initialize Summernote for rich-text content.
        if ($('.aiz-text-editor').length && $.fn.summernote) {
            $('.aiz-text-editor').each(function () {
                if (!$(this).next().hasClass('note-editor')) {
                    $(this).summernote({
                        height: 180,
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
