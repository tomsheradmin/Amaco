<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubsidiaryCompany;
use App\Models\SubsidiaryEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SubsidiaryController extends Controller
{
    // ADMIN: LIST
    public function index()
    {
        $companies = SubsidiaryCompany::withCount('enquiries')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(15);

        return view('backend.subsidiaries.index', compact('companies'));
    }

    // ADMIN: CREATE FORM
    public function create()
    {
        return view('backend.subsidiaries.create', [
            'company' => new SubsidiaryCompany(),
        ]);
    }

    // ADMIN: SAVE
    public function store(Request $request)
    {
        $data = $this->validateCompany($request);

        $company = DB::transaction(function () use ($request, $data) {
            $data['slug'] = SubsidiaryCompany::uniqueSlug($data['name']);
            $data['created_by'] = Auth::id();
            $data['services'] = $this->cleanItems($data['services'] ?? []);
            $data['highlights'] = $this->cleanItems($data['highlights'] ?? []);
            $data['documents'] = [];

            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')
                    ->store('subsidiaries/banners', 'public');
            }

            $data['documents'] = $this->storeDocuments($request, []);

            return SubsidiaryCompany::create($data);
        });

        return redirect()
            ->route('subsidiaries.edit', $company)
            ->with('success', 'Subsidiary company created successfully.');
    }

    // ADMIN: EDIT FORM
    public function edit(SubsidiaryCompany $subsidiary)
    {
        return view('backend.subsidiaries.edit', [
            'company' => $subsidiary,
        ]);
    }

    // ADMIN: UPDATE
    public function update(Request $request, SubsidiaryCompany $subsidiary)
    {
        $data = $this->validateCompany($request);

        DB::transaction(function () use ($request, $data, $subsidiary) {
            if ($request->boolean('regenerate_slug')) {
                $data['slug'] = SubsidiaryCompany::uniqueSlug(
                    $data['name'],
                    $subsidiary->id
                );
            }

            if ($request->hasFile('banner_image')) {
                $newImage = $request->file('banner_image')
                    ->store('subsidiaries/banners', 'public');

                if ($subsidiary->banner_image) {
                    Storage::disk('public')->delete($subsidiary->banner_image);
                }

                $data['banner_image'] = $newImage;
            }

            $data['services'] = $this->cleanItems($data['services'] ?? []);
            $data['highlights'] = $this->cleanItems($data['highlights'] ?? []);

            $existingDocuments = $subsidiary->documents ?? [];

            // Only remove documents that belong to this company.
            $removeIds = collect($request->input('remove_documents', []))
                ->map(fn ($id) => (string) $id)
                ->all();

            foreach ($existingDocuments as $document) {
                if (in_array((string) ($document['id'] ?? ''), $removeIds, true)) {
                    Storage::disk('local')->delete($document['path']);
                }
            }

            $existingDocuments = array_values(array_filter(
                $existingDocuments,
                fn ($document) => !in_array(
                    (string) ($document['id'] ?? ''),
                    $removeIds,
                    true
                )
            ));

            $data['documents'] = $this->storeDocuments(
                $request,
                $existingDocuments
            );

            $subsidiary->update($data);
        });

        return redirect()
            ->route('subsidiaries.edit', $subsidiary)
            ->with('success', 'Subsidiary company updated successfully.');
    }

    // ADMIN: DELETE
    public function destroy(SubsidiaryCompany $subsidiary)
    {
        if ($subsidiary->enquiries()->exists()) {
            return back()->with(
                'error',
                'This company has enquiries. Unpublish it instead of deleting it.'
            );
        }

        DB::transaction(function () use ($subsidiary) {
            if ($subsidiary->banner_image) {
                Storage::disk('public')->delete($subsidiary->banner_image);
            }

            foreach ($subsidiary->documents ?? [] as $document) {
                Storage::disk('local')->delete($document['path']);
            }

            $subsidiary->delete();
        });

        return redirect()
            ->route('subsidiaries.index')
            ->with('success', 'Subsidiary deleted successfully.');
    }

    // PUBLIC: LANDING PAGE
    public function show(string $slug)
    {
        $company = SubsidiaryCompany::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('subsidiaries.show', compact('company'));
    }

    // PUBLIC: DOCUMENT DOWNLOAD
    public function downloadDocument(string $slug, string $documentId)
    {
        $company = SubsidiaryCompany::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $document = collect($company->documents ?? [])
            ->firstWhere('id', $documentId);

        abort_unless($document && !empty($document['path']), 404);
        abort_unless(Storage::disk('local')->exists($document['path']), 404);

        return Storage::disk('local')->download(
            $document['path'],
            $document['original_name'] ?? 'company-document'
        );
    }

    // PUBLIC: ENQUIRY SUBMISSION
    public function enquire(Request $request, string $slug)
    {
        $company = SubsidiaryCompany::published()
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($company->enquiry_enabled, 404);

        // Hidden honeypot field for basic bot detection.
        if ($request->filled('website_confirmation')) {
            return back()->with('success', 'Thank you. Your enquiry has been received.');
        }

        $key = 'subsidiary-enquiry:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many enquiries. Please try again later.',
            ]);
        }

        RateLimiter::hit($key, 600);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        SubsidiaryEnquiry::create([
            ...$data,
            'subsidiary_company_id' => $company->id,
            'status' => 'new',
        ]);

        return back()->with(
            'success',
            'Thank you for contacting ' . $company->name . '. Your enquiry has been received.'
        );
    }

    private function validateCompany(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'overview' => ['nullable', 'string'],
            'banner_heading' => ['nullable', 'string', 'max:255'],
            'banner_subtitle' => ['nullable', 'string', 'max:1000'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'website_url' => [
                'nullable',
                'url:http,https',
                'max:2048',
            ],
            'website_button_text' => ['required', 'string', 'max:100'],

            'services' => ['nullable', 'array', 'max:30'],
            'services.*.title' => ['nullable', 'string', 'max:255'],
            'services.*.description' => ['nullable', 'string', 'max:3000'],

            'highlights' => ['nullable', 'array', 'max:30'],
            'highlights.*.title' => ['nullable', 'string', 'max:255'],
            'highlights.*.value' => ['nullable', 'string', 'max:100'],
            'highlights.*.description' => ['nullable', 'string', 'max:2000'],

            'documents' => ['nullable', 'array', 'max:20'],
            'documents.*.title' => ['nullable', 'string', 'max:255'],
            'documents.*.description' => ['nullable', 'string', 'max:1000'],
            'documents.*.file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                'max:10240',
            ],

            'remove_documents' => ['nullable', 'array'],
            'remove_documents.*' => ['string', 'max:100'],

            'enquiry_email' => ['nullable', 'email', 'max:255'],
            'enquiry_enabled' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'regenerate_slug' => ['nullable', 'boolean'],
        ]);
    }

    private function cleanItems(array $items): array
    {
        return collect($items)
            ->filter(fn ($item) => filled($item['title'] ?? null))
            ->map(function ($item) {
                return collect($item)
                    ->only(['title', 'value', 'description'])
                    ->map(fn ($value) => is_string($value) ? trim($value) : $value)
                    ->all();
            })
            ->values()
            ->all();
    }

    private function storeDocuments(Request $request, array $documents): array
    {
        foreach ($request->input('documents', []) as $index => $item) {
            $file = $request->file("documents.$index.file");

            if (!$file) {
                continue;
            }

            $documents[] = [
                'id' => (string) Str::uuid(),
                'title' => trim($item['title'] ?? '') ?: $file->getClientOriginalName(),
                'description' => trim($item['description'] ?? ''),
                'path' => $file->store('subsidiaries/documents', 'local'),
                'original_name' => $file->getClientOriginalName(),
            ];
        }

        return array_values($documents);
    }
}
