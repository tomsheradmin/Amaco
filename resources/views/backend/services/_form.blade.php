@php
    $features = old('features', $service->features ?? []);

    if (empty($features)) {
        $features = [
            [
                'title' => '',
                'description' => '',
            ]
        ];
    }
@endphp

<div class="row">

    {{-- LEFT COLUMN --}}
    <div class="col-lg-8">

        {{-- Basic Information --}}
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0 h6">
                    Basic Information
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>
                        Service Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $service->name ?? '') }}"
                        class="form-control"
                        placeholder="Enter service name"
                        required
                    >

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">

                    <label>Slug</label>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $service->slug ?? '') }}"
                        class="form-control"
                        placeholder="service-slug"
                    >

                    <small class="text-muted">
                        Leave empty to generate automatically from the service name.
                    </small>

                    @error('slug')
                        <small class="text-danger d-block">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Short Description</label>

                    <textarea
                        name="short_description"
                        rows="4"
                        class="form-control"
                        placeholder="Enter a short description for service listings..."
                    >{{ old('short_description', $service->short_description ?? '') }}</textarea>

                </div>

                <div class="form-group">

                    <label>Full Description</label>

                    <textarea
                        name="description"
                        id="description"
                        class="aiz-text-editor"
                        data-min-height="300"
                    >{{ old('description', $service->description ?? '') }}</textarea>

                </div>

            </div>

        </div>


        {{-- Service Image --}}
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0 h6">
                    Service Image
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group">

                    <label>Main Image</label>

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
                            0 Files selected
                        </div>

                        <input
                            type="hidden"
                            name="image"
                            class="selected-files"
                            value="{{ old('image', $service->image ?? '') }}"
                        >

                    </div>

                    <div class="file-preview box sm"></div>

                </div>

            </div>

        </div>


        {{-- Features --}}
        <div class="card">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 h6">
                        Key Features
                    </h5>

                </div>

            </div>

            <div class="card-body">

                <div
                    class="features-repeater"
                    data-repeater-list="features"
                >

                    @foreach($features as $feature)

                        <div
                            class="border rounded p-3 mb-3"
                            data-repeater-item
                        >

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group mb-md-0">

                                        <label>
                                            Feature Title
                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            value="{{ $feature['title'] ?? '' }}"
                                            class="form-control"
                                            placeholder="Feature title"
                                        >

                                    </div>

                                </div>

                                <div class="col-md-7">

                                    <div class="form-group mb-md-0">

                                        <label>
                                            Description
                                        </label>

                                        <textarea
                                            name="description"
                                            rows="2"
                                            class="form-control"
                                            placeholder="Feature description"
                                        >{{ $feature['description'] ?? '' }}</textarea>

                                    </div>

                                </div>

                                <div class="col-md-1 d-flex align-items-end">

                                    <button
                                        type="button"
                                        data-repeater-delete
                                        class="btn btn-soft-danger btn-icon btn-circle btn-sm mb-1"
                                        title="Remove"
                                    >
                                        <i class="las la-trash"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <button
                    type="button"
                    data-repeater-create
                    class="btn btn-soft-primary"
                >
                    <i class="las la-plus"></i>
                    Add Feature
                </button>

            </div>

        </div>


        {{-- SEO --}}
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0 h6">
                    SEO Settings
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group">

                    <label>Meta Title</label>

                    <input
                        type="text"
                        name="meta_title"
                        value="{{ old('meta_title', $service->meta_title ?? '') }}"
                        class="form-control"
                    >

                </div>

                <div class="form-group">

                    <label>Meta Description</label>

                    <textarea
                        name="meta_description"
                        rows="3"
                        class="form-control"
                    >{{ old('meta_description', $service->meta_description ?? '') }}</textarea>

                </div>

                <div class="form-group">

                    <label>Meta Keywords</label>

                    <textarea
                        name="meta_keywords"
                        rows="2"
                        class="form-control"
                    >{{ old('meta_keywords', $service->meta_keywords ?? '') }}</textarea>

                </div>

                <hr>

                <h6 class="mb-3">
                    Open Graph
                </h6>

                <div class="form-group">

                    <label>OG Title</label>

                    <input
                        type="text"
                        name="og_title"
                        value="{{ old('og_title', $service->og_title ?? '') }}"
                        class="form-control"
                    >

                </div>

                <div class="form-group">

                    <label>OG Description</label>

                    <textarea
                        name="og_description"
                        rows="3"
                        class="form-control"
                    >{{ old('og_description', $service->og_description ?? '') }}</textarea>

                </div>

                <hr>

                <h6 class="mb-3">
                    Twitter
                </h6>

                <div class="form-group">

                    <label>Twitter Title</label>

                    <input
                        type="text"
                        name="twitter_title"
                        value="{{ old('twitter_title', $service->twitter_title ?? '') }}"
                        class="form-control"
                    >

                </div>

                <div class="form-group">

                    <label>Twitter Description</label>

                    <textarea
                        name="twitter_description"
                        rows="3"
                        class="form-control"
                    >{{ old('twitter_description', $service->twitter_description ?? '') }}</textarea>

                </div>

            </div>

        </div>

    </div>


    {{-- RIGHT COLUMN --}}
    <div class="col-lg-4">

        {{-- Publishing --}}
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0 h6">
                    Publishing
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group">

                    <label>
                        Subsidiary Company
                    </label>

                    <select
                        name="subsidiary_id"
                        class="form-control aiz-selectpicker"
                        data-live-search="true"
                    >

                        <option value="">
                            Select Subsidiary
                        </option>

                        @foreach($subsidiaries as $subsidiary)

                            <option
                                value="{{ $subsidiary->id }}"
                                @selected(
                                    old(
                                        'subsidiary_id',
                                        $service->subsidiary_id ?? ''
                                    ) == $subsidiary->id
                                )
                            >
                                {{ $subsidiary->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('subsidiary_id')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Sort Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        min="0"
                        value="{{ old('sort_order', $service->sort_order ?? 0) }}"
                        class="form-control"
                    >

                    <small class="text-muted">
                        Lower numbers appear first.
                    </small>

                </div>


                <div class="form-group mb-0">

                    <label class="aiz-switch aiz-switch-success mb-0">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            @checked(old('status', $service->status ?? true))
                        >

                        <span class="slider round"></span>

                    </label>

                    <label class="ml-2">
                        Active
                    </label>

                </div>

            </div>

        </div>


        {{-- Save --}}
        <div class="card">

            <div class="card-body">

                <button
                    type="submit"
                    class="btn btn-primary btn-block"
                >
                    <i class="las la-save"></i>
                    {{ isset($service) ? 'Update Service' : 'Save Service' }}
                </button>

            </div>

        </div>

    </div>

</div>


{{-- Repeater --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

<script>

    $(document).ready(function () {

        $('.features-repeater').repeater({
            initEmpty: false,

            defaultValues: {
                'title': '',
                'description': ''
            },

            show: function () {
                $(this).slideDown();

                if (typeof AIZ !== 'undefined' && AIZ.uploader) {
                    AIZ.uploader();
                }
            },

            hide: function (deleteElement) {

                if (confirm('Are you sure you want to remove this feature?')) {
                    $(this).slideUp(deleteElement);
                }

            }
        });

    });

</script>
