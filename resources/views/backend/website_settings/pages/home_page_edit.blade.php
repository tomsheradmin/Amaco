@extends('backend.layouts.app')

@section('content')

@php
    $homeSettings = $page ? json_decode($page->data, true) : [];

    $heroSlides = $homeSettings['hero_slides'] ?? [];
    $subsidiaries = $homeSettings['subsidiaries'] ?? [];
    $services = $homeSettings['services'] ?? [];
    $strategies = $homeSettings['strategies'] ?? [];
    $milestones = $homeSettings['milestones'] ?? [];
    $faqs = $homeSettings['faqs'] ?? [];
    $latestNews = $homeSettings['latest_news'] ?? [];
    $quickLinks = $homeSettings['quick_links'] ?? [];
@endphp

<div class="row">
    <div class="col-xl-12 mx-auto">

        <form action="{{ route('business_settings.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="type" value="{{ $page->slug }}">

            {{-- ============================================================
                HEADER BANNER / SLIDERS
            ============================================================ --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Header Banner / Sliders</h5>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            Select Sliders
                        </label>

                        <div class="col-md-9">

                            <select
                                name="slider_ids[]"
                                class="form-control aiz-selectpicker"
                                multiple
                                data-live-search="true"
                                data-selected-text-format="count > 3"
                                title="Select sliders"
                            >

                                @foreach($sliders as $slider)

                                    <option
                                        value="{{ $slider->id }}"
                                        {{ in_array($slider->id, $homeSettings['slider_ids'] ?? []) ? 'selected' : '' }}
                                    >
                                        {{ $slider->title }}
                                        ({{ ucfirst($slider->type) }})
                                    </option>

                                @endforeach

                            </select>

                            <small class="text-muted">
                                Select multiple active sliders to display in the homepage header banner.
                                Slider content such as image/video, title and buttons is managed from Slider Management.
                            </small>

                        </div>
                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- GROUP COMPANY INTRODUCTION --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Group Company Introduction</h6>
                </div>

                <div class="card-body">

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>Main Title</label>

                            <input type="text"
                                   name="group_intro_title"
                                   value="{{ $homeSettings['group_intro_title'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-6">
                            <label>Short Highlight</label>

                            <input type="text"
                                   name="group_intro_highlight"
                                   value="{{ $homeSettings['group_intro_highlight'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Description</label>

                        <textarea name="group_intro_description"
                                  class="aiz-text-editor"
                                  data-min-height="150">{{ $homeSettings['group_intro_description'] ?? '' }}</textarea>
                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>Image</label>

                            <div class="input-group"
                                 data-toggle="aizuploader"
                                 data-type="image">

                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ trans('messages.browse') }}
                                    </div>
                                </div>

                                <div class="form-control form-control-sm file-amount">
                                    {{ !empty($homeSettings['group_intro_image'])
                                        ? basename($homeSettings['group_intro_image'])
                                        : trans('messages.choose_file') }}
                                </div>

                                <input type="hidden"
                                       name="group_intro_image"
                                       class="selected-files"
                                       value="{{ $homeSettings['group_intro_image'] ?? '' }}">
                            </div>

                            <div class="file-preview box sm"></div>
                        </div>

                        <div class="col-md-6">
                            <label>Button Text</label>

                            <input type="text"
                                   name="group_intro_button_text"
                                   value="{{ $homeSettings['group_intro_button_text'] ?? '' }}"
                                   class="form-control form-control-sm">

                            <label class="mt-3">Button Link</label>

                            <input type="text"
                                   name="group_intro_button_link"
                                   value="{{ $homeSettings['group_intro_button_link'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- SUBSIDIARY COMPANIES --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Subsidiary Companies</h6>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label>Section Title</label>

                        <input type="text"
                               name="subsidiaries_title"
                               value="{{ $homeSettings['subsidiaries_title'] ?? '' }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="subsidiaries-repeater">

                        <div data-repeater-list="subsidiaries">

                            @forelse($subsidiaries as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Company Name</label>

                                            <input type="text"
                                                   name="company_name"
                                                   value="{{ $item['company_name'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Logo / Image</label>

                                            <div class="input-group"
                                                 data-toggle="aizuploader"
                                                 data-type="image">

                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ trans('messages.browse') }}
                                                    </div>
                                                </div>

                                                <div class="form-control form-control-sm file-amount">
                                                    {{ !empty($item['image'])
                                                        ? basename($item['image'])
                                                        : trans('messages.choose_file') }}
                                                </div>

                                                <input type="hidden"
                                                       name="image"
                                                       class="selected-files"
                                                       value="{{ $item['image'] ?? '' }}">
                                            </div>

                                            <div class="file-preview box sm"></div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="3">{{ $item['description'] ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Link</label>

                                            <input type="text"
                                                   name="link"
                                                   value="{{ $item['link'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Company Name</label>
                                            <input type="text"
                                                   name="company_name"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Logo / Image</label>

                                            <div class="input-group"
                                                 data-toggle="aizuploader"
                                                 data-type="image">

                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ trans('messages.browse') }}
                                                    </div>
                                                </div>

                                                <div class="form-control form-control-sm file-amount">
                                                    {{ trans('messages.choose_file') }}
                                                </div>

                                                <input type="hidden"
                                                       name="image"
                                                       class="selected-files">
                                            </div>

                                            <div class="file-preview box sm"></div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="3"></textarea>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Link</label>

                                            <input type="text"
                                                   name="link"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add Company
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- MAJOR SERVICES / BUSINESS AREAS --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Major Services & Business Areas</h6>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label>Section Title</label>

                        <input type="text"
                               name="services_title"
                               value="{{ $homeSettings['services_title'] ?? '' }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="services-repeater">

                        <div data-repeater-list="services">

                            @forelse($services as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Service / Business Area</label>

                                            <input type="text"
                                                   name="title"
                                                   value="{{ $item['title'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Image</label>

                                            <div class="input-group"
                                                 data-toggle="aizuploader"
                                                 data-type="image">

                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ trans('messages.browse') }}
                                                    </div>
                                                </div>

                                                <div class="form-control form-control-sm file-amount">
                                                    {{ !empty($item['image'])
                                                        ? basename($item['image'])
                                                        : trans('messages.choose_file') }}
                                                </div>

                                                <input type="hidden"
                                                       name="image"
                                                       class="selected-files"
                                                       value="{{ $item['image'] ?? '' }}">
                                            </div>

                                            <div class="file-preview box sm"></div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="3">{{ $item['description'] ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label>Link</label>

                                            <input type="text"
                                                   name="link"
                                                   value="{{ $item['link'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Service / Business Area</label>

                                            <input type="text"
                                                   name="title"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Image</label>

                                            <div class="input-group"
                                                 data-toggle="aizuploader"
                                                 data-type="image">

                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ trans('messages.browse') }}
                                                    </div>
                                                </div>

                                                <div class="form-control form-control-sm file-amount">
                                                    {{ trans('messages.choose_file') }}
                                                </div>

                                                <input type="hidden"
                                                       name="image"
                                                       class="selected-files">
                                            </div>

                                            <div class="file-preview box sm"></div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="3"></textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label>Link</label>

                                            <input type="text"
                                                   name="link"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add Service
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- KEY FEATURES & STRATEGIES --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Key Features & Strategies</h6>
                </div>

                <div class="card-body">

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>Section Title</label>

                            <input type="text"
                                   name="strategies_title"
                                   value="{{ $homeSettings['strategies_title'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-6">
                            <label>Section Description</label>

                            <input type="text"
                                   name="strategies_description"
                                   value="{{ $homeSettings['strategies_description'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="strategies-repeater">

                        <div data-repeater-list="strategies">

                            @forelse($strategies as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Title</label>

                                            <input type="text"
                                                   name="title"
                                                   value="{{ $item['title'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-7">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="2">{{ $item['description'] ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label>Icon</label>

                                            <input type="text"
                                                   name="icon"
                                                   value="{{ $item['icon'] ?? '' }}"
                                                   class="form-control form-control-sm"
                                                   placeholder="la la-star">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label>Title</label>

                                            <input type="text"
                                                   name="title"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-7">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="2"></textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label>Icon</label>

                                            <input type="text"
                                                   name="icon"
                                                   class="form-control form-control-sm"
                                                   placeholder="la la-star">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add Feature
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- ACHIEVEMENTS & MILESTONES --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Achievements & Milestones</h6>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label>Section Title</label>

                        <input type="text"
                               name="milestones_title"
                               value="{{ $homeSettings['milestones_title'] ?? '' }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="milestones-repeater">

                        <div data-repeater-list="milestones">

                            @forelse($milestones as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-2">
                                            <label>Year / Number</label>

                                            <input type="text"
                                                   name="year"
                                                   value="{{ $item['year'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Title</label>

                                            <input type="text"
                                                   name="title"
                                                   value="{{ $item['title'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="2">{{ $item['description'] ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-2">
                                            <label>Year / Number</label>

                                            <input type="text"
                                                   name="year"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Title</label>

                                            <input type="text"
                                                   name="title"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Description</label>

                                            <textarea name="description"
                                                      class="form-control form-control-sm"
                                                      rows="2"></textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add Milestone
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- FAQ --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">FAQ Section</h6>
                </div>

                <div class="card-body">

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>Section Title</label>

                            <input type="text"
                                   name="faq_title"
                                   value="{{ $homeSettings['faq_title'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-6">
                            <label>Section Description</label>

                            <input type="text"
                                   name="faq_description"
                                   value="{{ $homeSettings['faq_description'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="faq-repeater">

                        <div data-repeater-list="faqs">

                            @forelse($faqs as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-5">
                                            <label>Question</label>

                                            <input type="text"
                                                   name="question"
                                                   value="{{ $item['question'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Answer</label>

                                            <textarea name="answer"
                                                      class="form-control form-control-sm"
                                                      rows="3">{{ $item['answer'] ?? '' }}</textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-5">
                                            <label>Question</label>

                                            <input type="text"
                                                   name="question"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Answer</label>

                                            <textarea name="answer"
                                                      class="form-control form-control-sm"
                                                      rows="3"></textarea>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add FAQ
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ============================================================
                LATEST NEWS & UPDATES
            ============================================================ --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Latest News & Updates</h5>
                </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            Section Title
                        </label>

                        <div class="col-md-9">
                            <input
                                type="text"
                                name="latest_news_title"
                                class="form-control"
                                placeholder="Latest News & Updates"
                                value="{{ $homeSettings['latest_news_title'] ?? 'Latest News & Updates' }}"
                            >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            Section Description
                        </label>

                        <div class="col-md-9">
                            <textarea
                                name="latest_news_description"
                                class="form-control"
                                rows="3"
                                placeholder="Stay updated with our latest news, announcements and updates."
                            >{{ $homeSettings['latest_news_description'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            Number of Posts
                        </label>

                        <div class="col-md-9">
                            <select name="latest_news_count" class="form-control select2">
                                @foreach([3, 4, 6, 8] as $count)
                                    <option
                                        value="{{ $count }}"
                                        {{ ($homeSettings['latest_news_count'] ?? 3) == $count ? 'selected' : '' }}
                                    >
                                        {{ $count }} Posts
                                    </option>
                                @endforeach
                            </select>

                            <small class="text-muted">
                                The latest active blog posts will be displayed automatically.
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            Button Text
                        </label>

                        <div class="col-md-9">
                            <input
                                type="text"
                                name="latest_news_button_text"
                                class="form-control"
                                placeholder="View All News"
                                value="{{ $homeSettings['latest_news_button_text'] ?? 'View All News' }}"
                            >
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-md-3 col-form-label">
                            Button Link
                        </label>

                        <div class="col-md-9">
                            <input
                                type="text"
                                name="latest_news_button_link"
                                class="form-control"
                                placeholder="/blog"
                                value="{{ $homeSettings['latest_news_button_link'] ?? '/blog' }}"
                            >
                        </div>
                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- QUICK LINKS & CTA --}}
            {{-- ========================================================= --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Links & Call To Action</h6>
                </div>

                <div class="card-body">

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label>CTA Title</label>

                            <input type="text"
                                   name="cta_title"
                                   value="{{ $homeSettings['cta_title'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-6">
                            <label>CTA Description</label>

                            <input type="text"
                                   name="cta_description"
                                   value="{{ $homeSettings['cta_description'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-md-4">
                            <label>CTA Button Text</label>

                            <input type="text"
                                   name="cta_button_text"
                                   value="{{ $homeSettings['cta_button_text'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label>CTA Button Link</label>

                            <input type="text"
                                   name="cta_button_link"
                                   value="{{ $homeSettings['cta_button_link'] ?? '' }}"
                                   class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label>CTA Background Image</label>

                            <div class="input-group"
                                 data-toggle="aizuploader"
                                 data-type="image">

                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ trans('messages.browse') }}
                                    </div>
                                </div>

                                <div class="form-control form-control-sm file-amount">
                                    {{ !empty($homeSettings['cta_background_image'])
                                        ? basename($homeSettings['cta_background_image'])
                                        : trans('messages.choose_file') }}
                                </div>

                                <input type="hidden"
                                       name="cta_background_image"
                                       class="selected-files"
                                       value="{{ $homeSettings['cta_background_image'] ?? '' }}">
                            </div>

                            <div class="file-preview box sm"></div>
                        </div>

                    </div>


                    <hr>

                    <h6 class="mb-3">Quick Links</h6>

                    <div class="quick-links-repeater">

                        <div data-repeater-list="quick_links">

                            @forelse($quickLinks as $item)

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-4">
                                            <label>Link Title</label>

                                            <input type="text"
                                                   name="title"
                                                   value="{{ $item['title'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-5">
                                            <label>Link URL</label>

                                            <input type="text"
                                                   name="link"
                                                   value="{{ $item['link'] ?? '' }}"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Icon</label>

                                            <input type="text"
                                                   name="icon"
                                                   value="{{ $item['icon'] ?? '' }}"
                                                   class="form-control form-control-sm"
                                                   placeholder="la la-arrow-right">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div data-repeater-item
                                     class="border shadow p-3 mb-3">

                                    <div class="form-group row">

                                        <div class="col-md-4">
                                            <label>Link Title</label>

                                            <input type="text"
                                                   name="title"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-5">
                                            <label>Link URL</label>

                                            <input type="text"
                                                   name="link"
                                                   class="form-control form-control-sm">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Icon</label>

                                            <input type="text"
                                                   name="icon"
                                                   class="form-control form-control-sm"
                                                   placeholder="la la-arrow-right">
                                        </div>

                                        <div class="col-md-1">
                                            <label class="d-block">&nbsp;</label>

                                            <button type="button"
                                                    data-repeater-delete
                                                    class="btn btn-danger btn-icon btn-sm">

                                                <i class="las la-trash"></i>

                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <div class="text-right">
                            <button type="button"
                                    data-repeater-create
                                    class="btn btn-primary btn-xs">
                                Add Quick Link
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- SEO --}}
            {{-- ========================================================= --}}

            @include('backend.inc.page_seo', [
                'settings' => $homeSettings
            ])


            {{-- ========================================================= --}}
            {{-- UPDATE --}}
            {{-- ========================================================= --}}

            <div class="text-right mb-2">
                <button type="submit"
                        class="btn btn-info btn-sm">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection


@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
</script>


<script type="text/javascript">

    $(function () {

        function initRepeater(selector) {

            $(selector).repeater({

                initEmpty: false,

                defaultValues: {},

                show: function () {

                    $(this).slideDown();

                    /*
                     * Re-initialize AIZ uploader/selectpicker
                     * for dynamically created repeater items.
                     */
                    $(this)
                        .find('.aiz-selectpicker')
                        .selectpicker('refresh');

                },

                hide: function (deleteElement) {

                    $(this).slideUp(deleteElement);

                }

            });

        }


        initRepeater('.subsidiaries-repeater');

        initRepeater('.services-repeater');

        initRepeater('.strategies-repeater');

        initRepeater('.milestones-repeater');

        initRepeater('.faq-repeater');

        initRepeater('.quick-links-repeater');

    });

</script>

@endsection
