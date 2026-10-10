@php
    $services = old('services', $company->services ?? []);
    $highlights = old('highlights', $company->highlights ?? []);
    $documents = old('documents', []);
@endphp

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($httpMethod !== 'POST')
        @method($httpMethod)
    @endif

    {{-- BASIC INFORMATION --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Company Information</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Subsidiary Name *</label>
                <input type="text" name="name" class="form-control" required
                       value="{{ old('name', $company->name) }}">
            </div>

            @if($company->exists)
                <div class="form-group">
                    <label>Current URL Slug</label>
                    <input type="text" class="form-control"
                           value="{{ $company->slug }}" disabled>
                    <label class="mt-2">
                        <input type="checkbox" name="regenerate_slug" value="1">
                        Generate a new slug from the company name
                    </label>
                </div>
            @endif

            <div class="form-group">
                <label>Tagline</label>
                <input type="text" name="tagline" class="form-control"
                       value="{{ old('tagline', $company->tagline) }}">
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea name="short_description" rows="3" class="form-control">{{ old('short_description', $company->short_description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Company Overview</label>
                <textarea name="overview" rows="6" class="form-control">{{ old('overview', $company->overview) }}</textarea>
            </div>
        </div>
    </div>

    {{-- BANNER --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Banner Section</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Banner Heading</label>
                <input type="text" name="banner_heading" class="form-control"
                       value="{{ old('banner_heading', $company->banner_heading) }}">
            </div>

            <div class="form-group">
                <label>Banner Subtitle</label>
                <textarea name="banner_subtitle" rows="2" class="form-control">{{ old('banner_subtitle', $company->banner_subtitle) }}</textarea>
            </div>

            <div class="form-group">
                <label>Banner Image</label>
                <input type="file" name="banner_image" class="form-control-file"
                       accept=".jpg,.jpeg,.png,.webp">

                @if($company->banner_image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $company->banner_image) }}"
                             alt="Current banner" style="max-width:300px;height:auto">
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- EXTERNAL WEBSITE --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Official Website</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>External Website URL</label>
                <input type="url" name="website_url" class="form-control"
                       placeholder="https://example.com"
                       value="{{ old('website_url', $company->website_url) }}">
            </div>

            <div class="form-group">
                <label>Button Text</label>
                <input type="text" name="website_button_text" class="form-control"
                       required
                       value="{{ old('website_button_text', $company->website_button_text ?? 'Visit Official Website') }}">
            </div>
        </div>
    </div>

    {{-- SERVICES --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Services / Products</strong>
            <button type="button" class="btn btn-sm btn-primary"
                    onclick="addSubsidiaryRow('services')">Add Service</button>
        </div>
        <div class="card-body" id="services-container">
            @foreach($services as $i => $service)
                <div class="border rounded p-3 mb-3 repeat-row">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="services[{{ $i }}][title]" class="form-control"
                               value="{{ $service['title'] ?? '' }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>Description</label>
                        <textarea name="services[{{ $i }}][description]"
                                  class="form-control" rows="2">{{ $service['description'] ?? '' }}</textarea>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                            onclick="this.closest('.repeat-row').remove()">Remove</button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- HIGHLIGHTS --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Highlights / Achievements</strong>
            <button type="button" class="btn btn-sm btn-primary"
                    onclick="addSubsidiaryRow('highlights')">Add Highlight</button>
        </div>
        <div class="card-body" id="highlights-container">
            @foreach($highlights as $i => $highlight)
                <div class="border rounded p-3 mb-3 repeat-row">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="highlights[{{ $i }}][title]" class="form-control"
                               value="{{ $highlight['title'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>Value / Statistic (optional)</label>
                        <input name="highlights[{{ $i }}][value]" class="form-control"
                               value="{{ $highlight['value'] ?? '' }}">
                    </div>
                    <div class="form-group mb-0">
                        <label>Description</label>
                        <textarea name="highlights[{{ $i }}][description]"
                                  class="form-control" rows="2">{{ $highlight['description'] ?? '' }}</textarea>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                            onclick="this.closest('.repeat-row').remove()">Remove</button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- EXISTING DOCUMENTS --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Existing Documents</strong></div>
        <div class="card-body">
            @forelse($company->documents ?? [] as $document)
                <div class="border rounded p-3 mb-2">
                    <strong>{{ $document['title'] ?? 'Document' }}</strong>
                    <div class="text-muted small">
                        {{ $document['original_name'] ?? '' }}
                    </div>
                    <label class="mt-2">
                        <input type="checkbox" name="remove_documents[]"
                               value="{{ $document['id'] }}">
                        Remove this document
                    </label>
                </div>
            @empty
                <p class="text-muted mb-0">No documents uploaded yet.</p>
            @endforelse
        </div>
    </div>

    {{-- NEW DOCUMENTS --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Upload Documents</strong>
            <button type="button" class="btn btn-sm btn-primary"
                    onclick="addSubsidiaryRow('documents')">Add Document</button>
        </div>
        <div class="card-body" id="documents-container">
            <div class="repeat-row border rounded p-3 mb-3">
                <div class="form-group">
                    <label>Document Title</label>
                    <input name="documents[0][title]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="documents[0][description]" class="form-control"
                              rows="2"></textarea>
                </div>
                <div class="form-group mb-0">
                    <label>File (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX)</label>
                    <input type="file" name="documents[0][file]"
                           class="form-control-file"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                </div>
            </div>
        </div>
    </div>

    {{-- ENQUIRIES --}}
    <div class="card mb-4">
        <div class="card-header"><strong>Enquiry Form Settings</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Recipient Email</label>
                <input type="email" name="enquiry_email" class="form-control"
                       value="{{ old('enquiry_email', $company->enquiry_email) }}">
            </div>

            <label>
                <input type="checkbox" name="enquiry_enabled" value="1"
                    @checked(old('enquiry_enabled', $company->enquiry_enabled ?? true))>
                Enable enquiry form on this page
            </label>
        </div>
    </div>

    {{-- SEO AND PUBLISHING --}}
    <div class="card mb-4">
        <div class="card-header"><strong>SEO & Publishing</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Meta Title</label>
                <input name="meta_title" class="form-control"
                       value="{{ old('meta_title', $company->meta_title) }}">
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $company->meta_description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Display Order</label>
                <input type="number" min="0" name="sort_order" class="form-control"
                       value="{{ old('sort_order', $company->sort_order ?? 0) }}">
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                    <option value="draft" @selected(old('status', $company->status ?? 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $company->status) === 'published')>Published</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-primary">
            Save Subsidiary
        </button>
        <a href="{{ route('subsidiaries.index') }}"
           class="btn btn-light">Cancel</a>
    </div>
</form>

<script>
let subsidiaryIndexes = {
    services: {{ count($services) }},
    highlights: {{ count($highlights) }},
    documents: 1
};

function addSubsidiaryRow(type) {
    const index = subsidiaryIndexes[type]++;
    let html = '';

    if (type === 'services') {
        html = `
            <div class="border rounded p-3 mb-3 repeat-row">
                <div class="form-group">
                    <label>Title</label>
                    <input name="services[${index}][title]" class="form-control">
                </div>
                <div class="form-group mb-0">
                    <label>Description</label>
                    <textarea name="services[${index}][description]"
                              class="form-control" rows="2"></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                        onclick="this.closest('.repeat-row').remove()">Remove</button>
            </div>`;
    } else if (type === 'highlights') {
        html = `
            <div class="border rounded p-3 mb-3 repeat-row">
                <div class="form-group">
                    <label>Title</label>
                    <input name="highlights[${index}][title]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Value / Statistic</label>
                    <input name="highlights[${index}][value]" class="form-control">
                </div>
                <div class="form-group mb-0">
                    <label>Description</label>
                    <textarea name="highlights[${index}][description]"
                              class="form-control" rows="2"></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                        onclick="this.closest('.repeat-row').remove()">Remove</button>
            </div>`;
    } else if (type === 'documents') {
        html = `
            <div class="border rounded p-3 mb-3 repeat-row">
                <div class="form-group">
                    <label>Document Title</label>
                    <input name="documents[${index}][title]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="documents[${index}][description]"
                              class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group mb-0">
                    <label>File</label>
                    <input type="file" name="documents[${index}][file]"
                           class="form-control-file"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                        onclick="this.closest('.repeat-row').remove()">Remove</button>
            </div>`;
    }

    document.getElementById(type + '-container')
        .insertAdjacentHTML('beforeend', html);
}
</script>
