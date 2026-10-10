@extends('backend.layouts.app')

@section('content')
@php
    $settings = $page
        ? (json_decode($page->data, true) ?? [])
        : [];

    $showListingImage = $settings['show_listing_image'] ?? 1;
    $showListingDescription = $settings['show_listing_description'] ?? 1;
    $showViewDetailsButton = $settings['show_view_details_button'] ?? 1;
    $showListingSection = $settings['show_listing_section'] ?? 1;
    $showListingPagination = $settings['show_listing_pagination'] ?? 1;
    $showListingCta = $settings['show_listing_cta'] ?? 0;
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">
                Edit Subsidiary Listing Page
            </h1>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <strong>Note:</strong>
    These settings control the common layout and content of the page
    displaying all subsidiaries. Individual subsidiary details, images,
    descriptions, and SEO should be managed through the Subsidiary module.
</div>

<form
    action="{{ route('business_settings.update') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <input type="hidden" name="type" value="{{ $page->type }}">

    {{-- ====================================================== --}}
    {{-- 1. BANNER SETTINGS --}}
    {{-- ====================================================== --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Listing Page Banner</h5>
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
                        Common banner background for the main subsidiaries listing page.
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
                        name="banner_heading"
                        class="form-control form-control-sm"
                        value="{{ $settings['banner_heading'] ?? '' }}"
                        placeholder="e.g. Our Subsidiaries"
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
                        name="banner_subheading"
                        class="form-control form-control-sm"
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
                        name="banner_description"
                        class="form-control form-control-sm"
                        rows="3"
                        placeholder="Enter banner description"
                    >{{ $settings['banner_description'] ?? '' }}</textarea>
                </div>
            </div>

        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 2. INTRODUCTION SETTINGS --}}
    {{-- ====================================================== --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Introduction Section</h5>
        </div>

        <div class="card-body">

            {{-- Introduction Heading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Section Heading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        name="section_heading"
                        class="form-control form-control-sm"
                        value="{{ $settings['section_heading'] ?? '' }}"
                        placeholder="e.g. Our Business Network"
                    >
                </div>
            </div>

            {{-- Introduction Subheading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Section Subheading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        name="section_subheading"
                        class="form-control form-control-sm"
                        value="{{ $settings['section_subheading'] ?? '' }}"
                        placeholder="Enter a short introductory subtitle"
                    >
                </div>
            </div>

            {{-- Introduction Description --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Introduction Description
                </label>

                <div class="col-md-9">
                    <textarea
                        name="section_introduction"
                        class="aiz-text-editor"
                        placeholder="Describe the subsidiary network"
                    >{{ $settings['section_introduction'] ?? '' }}</textarea>

                    <small class="text-muted">
                        Shared introductory content displayed before the subsidiary list.
                    </small>
                </div>
            </div>

            {{-- Introduction Image --}}
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
                        Optional image to accompany the introduction.
                    </small>
                </div>
            </div>

        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 3. SUBSIDIARY LISTING SETTINGS --}}
    {{-- ====================================================== --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Subsidiary Listing Section</h5>
        </div>

        <div class="card-body">

            {{-- Show Listing Section --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Display Listing Section
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_listing_section"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_listing_section"
                            value="1"
                            {{ $showListingSection ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>
                </div>
            </div>

            {{-- Listing Heading --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Listing Heading
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        name="listing_heading"
                        class="form-control form-control-sm"
                        value="{{ $settings['listing_heading'] ?? '' }}"
                        placeholder="e.g. Explore Our Subsidiaries"
                    >
                </div>
            </div>

            {{-- Listing Subtitle --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Listing Subtitle
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        name="listing_subheading"
                        class="form-control form-control-sm"
                        value="{{ $settings['listing_subheading'] ?? '' }}"
                        placeholder="Enter listing subtitle"
                    >
                </div>
            </div>

            {{-- Listing Description --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Listing Description
                </label>

                <div class="col-md-9">
                    <textarea
                        name="listing_description"
                        class="form-control form-control-sm"
                        rows="3"
                        placeholder="Enter a short description above the subsidiary cards"
                    >{{ $settings['listing_description'] ?? '' }}</textarea>
                </div>
            </div>

            {{-- Cards Per Row --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Cards Per Row
                </label>

                <div class="col-md-9">
                    <select
                        name="cards_per_row"
                        class="form-control form-control-sm"
                    >
                        <option
                            value="2"
                            {{ (int) ($settings['cards_per_row'] ?? 3) === 2 ? 'selected' : '' }}
                        >
                            2 Columns
                        </option>

                        <option
                            value="3"
                            {{ (int) ($settings['cards_per_row'] ?? 3) === 3 ? 'selected' : '' }}
                        >
                            3 Columns
                        </option>

                        <option
                            value="4"
                            {{ (int) ($settings['cards_per_row'] ?? 3) === 4 ? 'selected' : '' }}
                        >
                            4 Columns
                        </option>
                    </select>

                    <small class="text-muted">
                        The frontend template must support the selected grid layout.
                    </small>
                </div>
            </div>

            {{-- Items Per Page --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Items Per Page
                </label>

                <div class="col-md-9">
                    <input
                        type="number"
                        name="items_per_page"
                        class="form-control form-control-sm"
                        min="1"
                        max="100"
                        value="{{ $settings['items_per_page'] ?? 9 }}"
                    >

                    <small class="text-muted">
                        Number of subsidiaries displayed on each page when pagination is enabled.
                    </small>
                </div>
            </div>

            {{-- Show Image --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Show Subsidiary Image
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_listing_image"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_listing_image"
                            value="1"
                            {{ $showListingImage ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>
                </div>
            </div>

            {{-- Show Description --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Show Subsidiary Description
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_listing_description"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_listing_description"
                            value="1"
                            {{ $showListingDescription ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>
                </div>
            </div>

            {{-- Show Details Button --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Show View Details Button
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_view_details_button"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_view_details_button"
                            value="1"
                            {{ $showViewDetailsButton ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>
                </div>
            </div>

            {{-- Details Button Text --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Details Button Text
                </label>

                <div class="col-md-9">
                    <input
                        type="text"
                        name="listing_button_text"
                        class="form-control form-control-sm"
                        value="{{ $settings['listing_button_text'] ?? 'View Details' }}"
                        placeholder="e.g. View Details"
                    >
                </div>
            </div>

            {{-- Pagination --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Enable Pagination
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_listing_pagination"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_listing_pagination"
                            value="1"
                            {{ $showListingPagination ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>

                    <small class="text-muted d-block mt-2">
                        Pagination must also be implemented in the listing controller.
                    </small>
                </div>
            </div>

        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 4. CALL TO ACTION SETTINGS --}}
    {{-- ====================================================== --}}

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Call to Action Section</h5>
        </div>

        <div class="card-body">

            {{-- Show CTA --}}
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Display CTA Section
                </label>

                <div class="col-md-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input
                            type="hidden"
                            name="show_listing_cta"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="show_listing_cta"
                            value="1"
                            {{ $showListingCta ? 'checked' : '' }}
                        >

                        <span></span>
                    </label>
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
                        name="cta_heading"
                        class="form-control form-control-sm"
                        value="{{ $settings['cta_heading'] ?? '' }}"
                        placeholder="e.g. Interested in Working With Us?"
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
                        name="cta_description"
                        class="form-control form-control-sm"
                        rows="3"
                        placeholder="Enter CTA description"
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
                        name="cta_button_text"
                        class="form-control form-control-sm"
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
                        name="cta_button_url"
                        class="form-control form-control-sm"
                        value="{{ $settings['cta_button_url'] ?? '' }}"
                        placeholder="Enter URL or route path"
                    >
                </div>
            </div>

        </div>
    </div>

    {{-- SEO --}}
    @include('backend.inc.page_seo', ['settings' => $settings])



    {{-- ====================================================== --}}
    {{-- SAVE --}}
    {{-- ====================================================== --}}

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
        // Initialize AIZ image uploader.
        if (typeof AIZ !== 'undefined' && AIZ.uploader) {
            AIZ.uploader();
        }

        // Initialize the rich-text editor.
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
