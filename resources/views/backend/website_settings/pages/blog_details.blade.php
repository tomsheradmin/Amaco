@extends('backend.layouts.app')

@section('content')
    @php
        $settings = $page ? (json_decode($page->data, true) ?? []) : [];
        $settings = is_array($settings) ? $settings : [];
    @endphp

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">
                    {{ __('News & Updates Details Page Settings') }}
                </h1>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        {{ __('These settings apply to all News & Updates detail pages. Individual article titles, descriptions, images, galleries, and SEO settings should be managed from the Blogs module.') }}
    </div>

    <form
        action="{{ route('business_settings.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <input type="hidden" name="type" value="{{ $page->type }}">

        {{-- Banner Settings --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Banner Settings') }}</h5>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Banner Image') }}
                    </label>

                    <div class="col-md-9">
                        <div
                            class="input-group"
                            data-toggle="aizuploader"
                            data-type="image"
                        >
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary">
                                    <i class="las la-upload"></i>
                                </div>
                            </div>

                            <div class="form-control file-amount">
                                {{ __('Choose Image') }}
                            </div>

                            <input
                                type="hidden"
                                name="banner_image"
                                class="selected-files"
                                value="{{ $settings['banner_image'] ?? '' }}"
                            >
                        </div>

                        <div class="file-preview box sm mt-2"></div>

                        <small class="text-muted">
                            {{ __('Select the common banner image displayed on News & Updates detail pages.') }}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Banner Heading') }}
                    </label>

                    <div class="col-md-9">
                        <input
                            type="text"
                            class="form-control"
                            name="banner_heading"
                            value="{{ $settings['banner_heading'] ?? '' }}"
                            placeholder="{{ __('Enter banner heading') }}"
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Banner Subheading') }}
                    </label>

                    <div class="col-md-9">
                        <input
                            type="text"
                            class="form-control"
                            name="banner_subheading"
                            value="{{ $settings['banner_subheading'] ?? '' }}"
                            placeholder="{{ __('Enter banner subheading') }}"
                        >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Banner Description') }}
                    </label>

                    <div class="col-md-9">
                        <textarea
                            class="aiz-text-editor"
                            name="banner_description"
                            placeholder="{{ __('Enter banner description') }}"
                        >{{ $settings['banner_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Common Content Settings --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Common Content Settings') }}</h5>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Section Heading') }}
                    </label>

                    <div class="col-md-9">
                        <input
                            type="text"
                            class="form-control"
                            name="content_heading"
                            value="{{ $settings['content_heading'] ?? '' }}"
                            placeholder="{{ __('Enter section heading') }}"
                        >

                        <small class="text-muted">
                            {{ __('Optional heading displayed above the article content area.') }}
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{ __('Section Introduction') }}
                    </label>

                    <div class="col-md-9">
                        <textarea
                            class="aiz-text-editor"
                            name="content_description"
                            placeholder="{{ __('Enter section introduction') }}"
                        >{{ $settings['content_description'] ?? '' }}</textarea>

                        <small class="text-muted">
                            {{ __('Optional introductory content shared across News & Updates detail pages.') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="mt-4 text-right">
            <button type="submit" class="btn btn-primary">
                <i class="las la-save"></i>
                {{ __('Save Settings') }}
            </button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.aiz-text-editor').each(function () {
                if (!$(this).next('.note-editor').length) {
                    // The AIZ theme normally initializes this editor automatically.
                    // Do not initialize it again if it is already active.
                }
            });
        });
    </script>
@endsection
