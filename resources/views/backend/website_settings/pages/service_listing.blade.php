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

        $settings = is_array($settings) ? $settings : [];

        $selectedServices = old(
            'selected_services',
            $settings['selected_services'] ?? []
        );

        $selectedServices = is_array($selectedServices)
            ? $selectedServices
            : [];
    @endphp

    <div class="row">
        <div class="col-xl-12 mx-auto">

            <form
                action="{{ route('business_settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <input
                    type="hidden"
                    name="type"
                    value="{{ $page->type }}"
                >

                {{-- ============================================================
                    PAGE BANNER
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Page Banner</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Banner Title
                                </label>

                                <input
                                    type="text"
                                    name="banner_title"
                                    value="{{ old('banner_title', $settings['banner_title'] ?? '') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Our Services"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Banner Subtitle
                                </label>

                                <input
                                    type="text"
                                    name="banner_subtitle"
                                    value="{{ old('banner_subtitle', $settings['banner_subtitle'] ?? '') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Discover Our Expertise"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Banner Description
                                </label>

                                <textarea
                                    name="banner_description"
                                    class="form-control aiz-text-editor"
                                    rows="4"
                                    placeholder="Enter a short introduction to your services..."
                                >{{ old('banner_description', $settings['banner_description'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Banner Image
                                </label>

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

                                    <div class="form-control file-amount form-control-sm">
                                        Choose File
                                    </div>

                                    <input
                                        type="hidden"
                                        name="banner_image"
                                        value="{{ old('banner_image', $settings['banner_image'] ?? '') }}"
                                        class="selected-files"
                                    >
                                </div>

                                <div class="file-preview box sm"></div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    SERVICES OVERVIEW
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Services Overview</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Section Title
                                </label>

                                <input
                                    type="text"
                                    name="services_title"
                                    value="{{ old('services_title', $settings['services_title'] ?? 'Our Services') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Our Services"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Section Heading
                                </label>

                                <input
                                    type="text"
                                    name="services_heading"
                                    value="{{ old('services_heading', $settings['services_heading'] ?? '') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Comprehensive Solutions for Your Business"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Section Description
                                </label>

                                <textarea
                                    name="services_description"
                                    class="form-control aiz-text-editor"
                                    rows="5"
                                    placeholder="Describe the range of services offered by your company..."
                                >{{ old('services_description', $settings['services_description'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Section Image
                                </label>

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

                                    <div class="form-control file-amount form-control-sm">
                                        Choose File
                                    </div>

                                    <input
                                        type="hidden"
                                        name="services_image"
                                        value="{{ old('services_image', $settings['services_image'] ?? '') }}"
                                        class="selected-files"
                                    >
                                </div>

                                <div class="file-preview box sm"></div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    SELECT SERVICES TO DISPLAY
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Select Services to Display</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    Services
                                </label>

                                <select
                                    name="selected_services[]"
                                    class="form-control aiz-selectpicker"
                                    multiple
                                    data-live-search="true"
                                    data-placeholder="Choose services to display"
                                >
                                    @forelse($services as $service)
                                        <option
                                            value="{{ $service->id }}"
                                            {{ in_array($service->id, $selectedServices) ? 'selected' : '' }}
                                        >
                                            {{ $service->name }}
                                        </option>
                                    @empty
                                        <option disabled>
                                            No services available. Please create services first.
                                        </option>
                                    @endforelse
                                </select>

                                <small class="text-muted">
                                    Select the services that should appear on the Services page.
                                    You can select multiple services.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="col-form-label">
                                    Number of Services to Display
                                </label>

                                <input
                                    type="number"
                                    name="services_limit"
                                    value="{{ old('services_limit', $settings['services_limit'] ?? 6) }}"
                                    class="form-control form-control-sm"
                                    min="1"
                                    max="100"
                                >

                                <small class="text-muted">
                                    Maximum number of selected services to show in the overview.
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">
                                    View All Button Text
                                </label>

                                <input
                                    type="text"
                                    name="view_all_text"
                                    value="{{ old('view_all_text', $settings['view_all_text'] ?? 'View All Services') }}"
                                    class="form-control form-control-sm"
                                    placeholder="View All Services"
                                >
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    CALL TO ACTION
                ============================================================= --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Call to Action</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    CTA Title
                                </label>

                                <input
                                    type="text"
                                    name="cta_title"
                                    value="{{ old('cta_title', $settings['cta_title'] ?? '') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Looking for the Right Solution?"
                                >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label">
                                    CTA Description
                                </label>

                                <textarea
                                    name="cta_description"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Enter a short call-to-action message..."
                                >{{ old('cta_description', $settings['cta_description'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <label class="col-form-label">
                                    Button Text
                                </label>

                                <input
                                    type="text"
                                    name="cta_button_text"
                                    value="{{ old('cta_button_text', $settings['cta_button_text'] ?? 'Contact Us') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Contact Us"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">
                                    Button URL
                                </label>

                                <input
                                    type="text"
                                    name="cta_button_url"
                                    value="{{ old('cta_button_url', $settings['cta_button_url'] ?? '') }}"
                                    class="form-control form-control-sm"
                                    placeholder="/contact-us"
                                >
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ============================================================
                    SEO
                ============================================================= --}}
                @include('backend.inc.page_seo', [
                    'settings' => $settings
                ])


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

    <script>
        $(document).ready(function () {

            var lang = '{{ $lang ?? "" }}';

            if (lang === 'ae') {
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

        });
    </script>

@endsection
