@extends('backend.layouts.app')

@section('content')
    @php
        $settings = $page ? (json_decode($page->data, true) ?? []) : [];
        $settings = is_array($settings) ? $settings : [];

        // Preserve existing description data saved under the old key.
        $description = $settings['description']
            ?? $settings['google_map_link']
            ?? '';

        $locations = $settings['contact_locations'] ?? [];

        if (!is_array($locations)) {
            $locations = [];
        }
    @endphp

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">
                    {{ __('Contact Us Page Settings') }}
                </h1>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        {{ __('Configure the company contact information, enquiry form, and locations of subsidiaries, offices, warehouses, and factories. Add multiple locations where required.') }}
    </div>

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <form
                action="{{ route('business_settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <input type="hidden" name="type" value="{{ $page->type }}">

                {{-- General Contact Information --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('General Contact Information') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Page Title') }}</label>
                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ $settings['title'] ?? '' }}"
                                placeholder="{{ __('Contact Us') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Subtitle') }}</label>
                            <input
                                type="text"
                                name="sub_title"
                                class="form-control"
                                value="{{ $settings['sub_title'] ?? '' }}"
                                placeholder="{{ __('How can we help you?') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Company Contact Description') }}</label>
                            <textarea
                                name="description"
                                class="aiz-text-editor"
                                rows="4"
                                placeholder="{{ __('Enter a brief introduction to your company and contact information.') }}"
                            >{{ $description }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Enquiry Form Settings --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Enquiry Form Settings') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Form Title') }}</label>
                            <input
                                type="text"
                                name="form_title"
                                class="form-control"
                                value="{{ $settings['form_title'] ?? '' }}"
                                placeholder="{{ __('Send Us an Enquiry') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Enquiry Form Description') }}</label>
                            <textarea
                                name="form_description"
                                class="form-control"
                                rows="3"
                                placeholder="{{ __('Enter a short message above the enquiry form.') }}"
                            >{{ $settings['form_description'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Enquiry Recipient Email') }}</label>
                            <input
                                type="email"
                                name="enquiry_email"
                                class="form-control"
                                value="{{ $settings['enquiry_email'] ?? '' }}"
                                placeholder="enquiries@example.com"
                            >
                            <small class="text-muted">
                                {{ __('The email address that should receive website enquiries. Ensure the enquiry form handler uses this setting.') }}
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Main Company Contact Details --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Main Company Contact Details') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Address Heading') }}</label>
                            <input
                                type="text"
                                name="address_heading"
                                class="form-control"
                                value="{{ $settings['address_heading'] ?? '' }}"
                                placeholder="{{ __('Our Address') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Company Address') }}</label>
                            <textarea
                                name="address_content"
                                class="form-control"
                                rows="3"
                                placeholder="{{ __('Enter the main company address') }}"
                            >{{ $settings['address_content'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Phone Heading') }}</label>
                            <input
                                type="text"
                                name="phone_heading"
                                class="form-control"
                                value="{{ $settings['phone_heading'] ?? '' }}"
                                placeholder="{{ __('Phone') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Contact Numbers') }}</label>
                            <textarea
                                name="phone_content"
                                class="form-control"
                                rows="2"
                                placeholder="{{ __('Enter phone numbers, one per line if needed') }}"
                            >{{ $settings['phone_content'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Email Heading') }}</label>
                            <input
                                type="text"
                                name="email_heading"
                                class="form-control"
                                value="{{ $settings['email_heading'] ?? '' }}"
                                placeholder="{{ __('Email') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{ __('Email Addresses') }}</label>
                            <textarea
                                name="email_content"
                                class="form-control"
                                rows="2"
                                placeholder="{{ __('Enter email addresses, one per line if needed') }}"
                            >{{ $settings['email_content'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Subsidiaries and Other Locations --}}
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">{{ __('Branches, Subsidiaries & Other Locations') }}</h6>

                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                            id="add-contact-location"
                        >
                            <i class="las la-plus"></i>
                            {{ __('Add Location') }}
                        </button>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            {{ __('Add a separate entry for each subsidiary, branch, office, warehouse, or factory. Leave this section empty if there are no additional locations.') }}
                        </p>

                        <div id="contact-locations-container">
                            @foreach ($locations as $index => $location)
                                <div class="contact-location border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="location-title mb-0">
                                            {{ __('Location') }} {{ $loop->iteration }}
                                        </h6>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-soft-danger remove-contact-location"
                                        >
                                            <i class="las la-trash"></i>
                                            {{ __('Remove') }}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Location / Company Name') }}</label>
                                        <input
                                            type="text"
                                            name="contact_locations[{{ $index }}][name]"
                                            class="form-control"
                                            value="{{ $location['name'] ?? '' }}"
                                            placeholder="{{ __('Enter subsidiary or location name') }}"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Location Type') }}</label>
                                        <select
                                            name="contact_locations[{{ $index }}][type]"
                                            class="form-control aiz-selectpicker"
                                            data-live-search="false"
                                        >
                                            @foreach ([
                                                'subsidiary' => 'Subsidiary',
                                                'branch' => 'Branch',
                                                'office' => 'Office',
                                                'warehouse' => 'Warehouse',
                                                'factory' => 'Factory',
                                                'head_office' => 'Head Office',
                                                'other' => 'Other',
                                            ] as $value => $label)
                                                <option
                                                    value="{{ $value }}"
                                                    @selected(($location['type'] ?? '') === $value)
                                                >
                                                    {{ __($label) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Address') }}</label>
                                        <textarea
                                            name="contact_locations[{{ $index }}][address]"
                                            class="form-control"
                                            rows="3"
                                            placeholder="{{ __('Enter full address') }}"
                                        >{{ $location['address'] ?? '' }}</textarea>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Contact Number') }}</label>
                                            <input
                                                type="text"
                                                name="contact_locations[{{ $index }}][phone]"
                                                class="form-control"
                                                value="{{ $location['phone'] ?? '' }}"
                                                placeholder="{{ __('Enter contact number') }}"
                                            >
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Email Address') }}</label>
                                            <input
                                                type="email"
                                                name="contact_locations[{{ $index }}][email]"
                                                class="form-control"
                                                value="{{ $location['email'] ?? '' }}"
                                                placeholder="{{ __('Enter email address') }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Google Maps Link') }}</label>
                                        <input
                                            type="url"
                                            name="contact_locations[{{ $index }}][map_url]"
                                            class="form-control"
                                            value="{{ $location['map_url'] ?? '' }}"
                                            placeholder="https://maps.google.com/..."
                                        >
                                        <small class="text-muted">
                                            {{ __('Paste the Google Maps share link for this location.') }}
                                        </small>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Latitude (Optional)') }}</label>
                                            <input
                                                type="text"
                                                name="contact_locations[{{ $index }}][latitude]"
                                                class="form-control"
                                                value="{{ $location['latitude'] ?? '' }}"
                                                placeholder="e.g. 25.2048"
                                            >
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Longitude (Optional)') }}</label>
                                            <input
                                                type="text"
                                                name="contact_locations[{{ $index }}][longitude]"
                                                class="form-control"
                                                value="{{ $location['longitude'] ?? '' }}"
                                                placeholder="e.g. 55.2708"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="no-contact-locations" class="text-center text-muted py-3"
                             style="{{ count($locations) ? 'display:none;' : '' }}">
                            {{ __('No additional locations have been added.') }}
                        </div>
                    </div>
                </div>

                {{-- Main Google Maps Location --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Main Company Google Maps Location') }}</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('Google Maps Link') }}</label>
                            <input
                                type="url"
                                name="google_map_url"
                                class="form-control"
                                value="{{ $settings['google_map_url'] ?? '' }}"
                                placeholder="https://maps.google.com/..."
                            >
                            <small class="text-muted">
                                {{ __('Paste the Google Maps share link for the main company address.') }}
                            </small>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Latitude (Optional)') }}</label>
                                <input
                                    type="text"
                                    name="map_latitude"
                                    class="form-control"
                                    value="{{ $settings['map_latitude'] ?? '' }}"
                                    placeholder="e.g. 25.2048"
                                >
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Longitude (Optional)') }}</label>
                                <input
                                    type="text"
                                    name="map_longitude"
                                    class="form-control"
                                    value="{{ $settings['map_longitude'] ?? '' }}"
                                    placeholder="e.g. 55.2708"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO Settings --}}
                @include('backend.inc.page_seo', ['settings' => $settings])

                <div class="text-right mb-4 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="las la-save"></i>
                        {{ __('Save Contact Page Settings') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            let locationIndex = {{ count($locations) }};

            const locationTypes = {{ Illuminate\Support\Js::from([
                'subsidiary' => __('Subsidiary'),
                'branch' => __('Branch'),
                'office' => __('Office'),
                'warehouse' => __('Warehouse'),
                'factory' => __('Factory'),
                'head_office' => __('Head Office'),
                'other' => __('Other'),
            ]) }};

            function escapeHtml(value) {
                return $('<div>').text(value).html();
            }

            function updateLocationTitles() {
                $('#contact-locations-container .contact-location').each(function (index) {
                    $(this).find('.location-title').text(
                        {{ Illuminate\Support\Js::from(__('Location')) }} + ' ' + (index + 1)
                    );
                });

                const hasLocations =
                    $('#contact-locations-container .contact-location').length > 0;

                $('#no-contact-locations').toggle(!hasLocations);
            }

            function addLocation() {
                let options = '';

                $.each(locationTypes, function (value, label) {
                    options += '<option value="' + escapeHtml(value) + '">' +
                        escapeHtml(label) + '</option>';
                });

                const html = `
                    <div class="contact-location border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="location-title mb-0"></h6>
                            <button type="button"
                                class="btn btn-sm btn-soft-danger remove-contact-location">
                                <i class="las la-trash"></i>
                                {{ __('Remove') }}
                            </button>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Location / Company Name') }}</label>
                            <input type="text"
                                name="contact_locations[${locationIndex}][name]"
                                class="form-control"
                                placeholder="{{ __('Enter subsidiary or location name') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Location Type') }}</label>
                            <select name="contact_locations[${locationIndex}][type]"
                                class="form-control">
                                ${options}
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="contact_locations[${locationIndex}][address]"
                                class="form-control" rows="3"
                                placeholder="{{ __('Enter full address') }}"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Contact Number') }}</label>
                                <input type="text"
                                    name="contact_locations[${locationIndex}][phone]"
                                    class="form-control"
                                    placeholder="{{ __('Enter contact number') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Email Address') }}</label>
                                <input type="email"
                                    name="contact_locations[${locationIndex}][email]"
                                    class="form-control"
                                    placeholder="{{ __('Enter email address') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Google Maps Link') }}</label>
                            <input type="url"
                                name="contact_locations[${locationIndex}][map_url]"
                                class="form-control"
                                placeholder="https://maps.google.com/...">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Latitude (Optional)') }}</label>
                                <input type="text"
                                    name="contact_locations[${locationIndex}][latitude]"
                                    class="form-control"
                                    placeholder="e.g. 25.2048">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Longitude (Optional)') }}</label>
                                <input type="text"
                                    name="contact_locations[${locationIndex}][longitude]"
                                    class="form-control"
                                    placeholder="e.g. 55.2708">
                            </div>
                        </div>
                    </div>
                `;

                $('#contact-locations-container').append(html);
                locationIndex++;

                updateLocationTitles();
            }

            $('#add-contact-location').on('click', function () {
                addLocation();
            });

            $(document).on('click', '.remove-contact-location', function () {
                $(this).closest('.contact-location').remove();
                updateLocationTitles();
            });

            updateLocationTitles();
        });
    </script>
@endsection
