@extends('backend.layouts.app')

@section('content')
    @php
        $settings = $page ? (json_decode($page->data, true) ?? []) : [];
        $settings = is_array($settings) ? $settings : [];
    @endphp

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ __('Careers Page Settings') }}</h1>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        {{ __('Configure the Careers page content here. Individual vacancies and candidate CV submissions should be managed through the careers management module.') }}
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
                <h6 class="mb-0">{{ __('Banner Settings') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('Banner Image') }}</label>

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
                </div>

                <div class="form-group">
                    <label>{{ __('Page Title') }}</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ $settings['title'] ?? '' }}"
                        placeholder="{{ __('Careers') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Subtitle') }}</label>
                    <input
                        type="text"
                        name="sub_title"
                        class="form-control"
                        value="{{ $settings['sub_title'] ?? '' }}"
                        placeholder="{{ __('Build Your Career With Us') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Banner Description') }}</label>
                    <textarea
                        name="banner_description"
                        class="aiz-text-editor"
                        rows="4"
                        placeholder="{{ __('Enter the Careers page banner description') }}"
                    >{{ $settings['banner_description'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Introduction Section --}}
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Introduction Section') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('Section Heading') }}</label>
                    <input
                        type="text"
                        name="intro_heading"
                        class="form-control"
                        value="{{ $settings['intro_heading'] ?? '' }}"
                        placeholder="{{ __('Join Our Team') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Introduction Content') }}</label>
                    <textarea
                        name="intro_description"
                        class="aiz-text-editor"
                        rows="5"
                        placeholder="{{ __('Describe your workplace, values, and career opportunities') }}"
                    >{{ $settings['intro_description'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Vacancies Section --}}
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Vacancies Section') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('Section Heading') }}</label>
                    <input
                        type="text"
                        name="vacancies_heading"
                        class="form-control"
                        value="{{ $settings['vacancies_heading'] ?? '' }}"
                        placeholder="{{ __('Current Job Openings') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Section Description') }}</label>
                    <textarea
                        name="vacancies_description"
                        class="form-control"
                        rows="3"
                        placeholder="{{ __('Introduce the available vacancies') }}"
                    >{{ $settings['vacancies_description'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ __('View Vacancies Button Text') }}</label>
                    <input
                        type="text"
                        name="vacancies_button_text"
                        class="form-control"
                        value="{{ $settings['vacancies_button_text'] ?? '' }}"
                        placeholder="{{ __('View Open Positions') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('No Vacancies Message') }}</label>
                    <input
                        type="text"
                        name="no_vacancies_message"
                        class="form-control"
                        value="{{ $settings['no_vacancies_message'] ?? '' }}"
                        placeholder="{{ __('There are currently no open positions.') }}"
                    >
                </div>
            </div>
        </div>

        {{-- CV Application Section --}}
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">{{ __('CV Application Section') }}</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>{{ __('Application Section Heading') }}</label>
                    <input
                        type="text"
                        name="application_heading"
                        class="form-control"
                        value="{{ $settings['application_heading'] ?? '' }}"
                        placeholder="{{ __('Apply for a Position') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Application Instructions') }}</label>
                    <textarea
                        name="application_description"
                        class="aiz-text-editor"
                        rows="4"
                        placeholder="{{ __('Explain how candidates can submit their CV and apply for vacancies') }}"
                    >{{ $settings['application_description'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>{{ __('CV Upload Label') }}</label>
                    <input
                        type="text"
                        name="cv_upload_label"
                        class="form-control"
                        value="{{ $settings['cv_upload_label'] ?? '' }}"
                        placeholder="{{ __('Upload Your CV') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('Application Button Text') }}</label>
                    <input
                        type="text"
                        name="application_button_text"
                        class="form-control"
                        value="{{ $settings['application_button_text'] ?? '' }}"
                        placeholder="{{ __('Submit Application') }}"
                    >
                </div>

                <div class="form-group">
                    <label>{{ __('General Application Email (Optional)') }}</label>
                    <input
                        type="email"
                        name="careers_email"
                        class="form-control"
                        value="{{ $settings['careers_email'] ?? '' }}"
                        placeholder="careers@example.com"
                    >

                    <small class="text-muted">
                        {{ __('Optional contact email for career enquiries. Configure the application handler to use this email if required.') }}
                    </small>
                </div>
            </div>
        </div>

        {{-- SEO Settings --}}
        @include('backend.inc.page_seo', ['settings' => $settings])

        <div class="text-right mb-4 mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="las la-save"></i>
                {{ __('Save Careers Settings') }}
            </button>
        </div>
    </form>
@endsection
