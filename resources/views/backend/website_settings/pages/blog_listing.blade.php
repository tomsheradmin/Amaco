
@extends('backend.layouts.app')

@section('content')

    @php
        $settings = $page ? json_decode($page->data, true) : [];
        $settings = is_array($settings) ? $settings : [];

        $selectedBlogs = old(
            'selected_blogs',
            $settings['selected_blogs'] ?? []
        );

        $selectedBlogs = is_array($selectedBlogs)
            ? array_map('strval', $selectedBlogs)
            : [];
    @endphp

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">
                    {{ __('Edit News & Updates Listing Page') }}
                </h1>
            </div>
        </div>
    </div>

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

                {{-- PAGE BANNER --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Page Banner') }}</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Banner Title') }}
                            </label>

                            <input
                                type="text"
                                name="banner_title"
                                value="{{ old('banner_title', $settings['banner_title'] ?? 'News & Updates') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('News & Updates') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Banner Subtitle') }}
                            </label>

                            <input
                                type="text"
                                name="banner_subtitle"
                                value="{{ old('banner_subtitle', $settings['banner_subtitle'] ?? '') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('Latest News, Insights and Announcements') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Banner Description') }}
                            </label>

                            <textarea
                                name="banner_description"
                                class="form-control aiz-text-editor"
                                rows="4"
                                placeholder="{{ __('Enter a short introduction to your news and updates...') }}"
                            >{{ old('banner_description', $settings['banner_description'] ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-0">
                            <label class="col-form-label">
                                {{ __('Banner Image') }}
                            </label>

                            <div
                                class="input-group"
                                data-toggle="aizuploader"
                                data-type="image"
                            >
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ __('Browse') }}
                                    </div>
                                </div>

                                <div class="form-control file-amount form-control-sm">
                                    {{ __('Choose File') }}
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

                {{-- NEWS LISTING INTRODUCTION --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('News Listing Introduction') }}</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Section Title') }}
                            </label>

                            <input
                                type="text"
                                name="news_title"
                                value="{{ old('news_title', $settings['news_title'] ?? 'News & Updates') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('News & Updates') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Section Heading') }}
                            </label>

                            <input
                                type="text"
                                name="news_heading"
                                value="{{ old('news_heading', $settings['news_heading'] ?? '') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('Explore Our Latest News and Insights') }}"
                            >
                        </div>

                        <div class="form-group mb-0">
                            <label class="col-form-label">
                                {{ __('Section Description') }}
                            </label>

                            <textarea
                                name="news_description"
                                class="form-control aiz-text-editor"
                                rows="4"
                                placeholder="{{ __('Enter an introduction to your news and updates...') }}"
                            >{{ old('news_description', $settings['news_description'] ?? '') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- SELECT BLOG POSTS --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Select News & Updates to Display') }}</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Blog Posts') }}
                            </label>

                            <select
                                name="selected_blogs[]"
                                class="form-control aiz-selectpicker"
                                multiple
                                data-live-search="true"
                                data-placeholder="{{ __('Choose news articles to display') }}"
                            >
                                @forelse($blogs as $blog)
                                    <option
                                        value="{{ $blog->id }}"
                                        {{ in_array((string) $blog->id, $selectedBlogs, true) ? 'selected' : '' }}
                                    >
                                        {{ $blog->title ?? $blog->name ?? ('Blog #' . $blog->id) }}
                                    </option>
                                @empty
                                    <option disabled>
                                        {{ __('No blog posts available. Please create blog posts first.') }}
                                    </option>
                                @endforelse
                            </select>

                            <small class="text-muted">
                                {{ __('Select the news articles to display on the News & Updates page. Leave all unselected if your frontend is configured to display posts automatically.') }}
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('Number of Posts to Display') }}
                            </label>

                            <input
                                type="number"
                                name="news_limit"
                                value="{{ old('news_limit', $settings['news_limit'] ?? 6) }}"
                                class="form-control form-control-sm"
                                min="1"
                                max="100"
                            >

                            <small class="text-muted">
                                {{ __('Maximum number of news articles to show in the listing.') }}
                            </small>
                        </div>

                        <div class="form-group mb-0">
                            <label class="col-form-label">
                                {{ __('View All Button Text') }}
                            </label>

                            <input
                                type="text"
                                name="view_all_text"
                                value="{{ old('view_all_text', $settings['view_all_text'] ?? 'View All News') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('View All News') }}"
                            >
                        </div>

                    </div>
                </div>

                {{-- CALL TO ACTION --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Call to Action') }}</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('CTA Title') }}
                            </label>

                            <input
                                type="text"
                                name="cta_title"
                                value="{{ old('cta_title', $settings['cta_title'] ?? '') }}"
                                class="form-control form-control-sm"
                                placeholder="{{ __('Stay Updated with Our Latest News') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                {{ __('CTA Description') }}
                            </label>

                            <textarea
                                name="cta_description"
                                class="form-control"
                                rows="3"
                                placeholder="{{ __('Enter a short call-to-action message...') }}"
                            >{{ old('cta_description', $settings['cta_description'] ?? '') }}</textarea>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <label class="col-form-label">
                                    {{ __('Button Text') }}
                                </label>

                                <input
                                    type="text"
                                    name="cta_button_text"
                                    value="{{ old('cta_button_text', $settings['cta_button_text'] ?? 'Contact Us') }}"
                                    class="form-control form-control-sm"
                                    placeholder="{{ __('Contact Us') }}"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">
                                    {{ __('Button URL') }}
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

                {{-- SEO --}}
                @include('backend.inc.page_seo', [
                    'settings' => $settings
                ])

                {{-- UPDATE --}}
                <div class="text-right mb-4">
                    <button type="submit" class="btn btn-info btn-sm">
                        {{ __('Update') }}
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        var lang = @json($lang ?? '');

        function setEditorDirection(isRtl) {
            var editor = $('.aiz-text-editor')
                .next('.note-editor')
                .find('.note-editable');

            editor.attr('dir', isRtl ? 'rtl' : 'ltr');
            editor.css('text-align', isRtl ? 'right' : 'left');
        }

        setEditorDirection(lang === 'ae');
    });
</script>
@endsection
