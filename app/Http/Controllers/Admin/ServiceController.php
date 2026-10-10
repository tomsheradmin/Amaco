<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SubsidiaryCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Admin listing.
     */
    public function index()
    {
        $services = Service::with('subsidiary')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('backend.services.index', compact('services'));
    }

    /**
     * Admin create page.
     */
    public function create()
    {
        $subsidiaries = SubsidiaryCompany::query()
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('backend.services.create', compact('subsidiaries'));
    }

    /**
     * Store service.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:services,slug',
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'subsidiary_id' => [
                'nullable',
                'integer',
                'exists:subsidiaries,id',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*.title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'features.*.description' => [
                'nullable',
                'string',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_description' => [
                'nullable',
                'string',
            ],

            'twitter_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'twitter_description' => [
                'nullable',
                'string',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Service::generateUniqueSlug($request->input('name'));

        // Clean feature data.
        $features = collect($request->input('features', []))
            ->filter(function ($feature) {
                return is_array($feature)
                    && (
                        !empty($feature['title'])
                        || !empty($feature['description'])
                    );
            })
            ->values()
            ->toArray();

        Service::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),

            // Associate this service with a subsidiary.
            'subsidiary_id' => $request->input('subsidiary_id') ?: null,

            'features' => $features,
            'status' => $request->boolean('status') ? 1 : 0,
            'sort_order' => $request->input('sort_order', 0),

            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),

            'og_title' => $request->input('og_title'),
            'og_description' => $request->input('og_description'),

            'twitter_title' => $request->input('twitter_title'),
            'twitter_description' => $request->input('twitter_description'),
        ]);

        return redirect()
            ->route('service.index')
            ->with('success', 'Service has been created successfully.');
    }

    /**
     * Admin edit page.
     */
    public function edit(Service $service)
    {
        $subsidiaries = SubsidiaryCompany::query()
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $service->load('subsidiary');

        return view('backend.services.edit', compact(
            'service',
            'subsidiaries'
        ));
    }

    /**
     * Update service.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:services,slug,' . $service->id,
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'subsidiary_id' => [
                'nullable',
                'integer',
                'exists:subsidiaries,id',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*.title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'features.*.description' => [
                'nullable',
                'string',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
            ],

            'og_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'og_description' => [
                'nullable',
                'string',
            ],

            'twitter_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'twitter_description' => [
                'nullable',
                'string',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $slug = $request->filled('slug')
            ? Str::slug($request->input('slug'))
            : Service::generateUniqueSlug(
                $request->input('name'),
                $service->id
            );

        // Clean feature data.
        $features = collect($request->input('features', []))
            ->filter(function ($feature) {
                return is_array($feature)
                    && (
                        !empty($feature['title'])
                        || !empty($feature['description'])
                    );
            })
            ->values()
            ->toArray();

        $service->update([
            'name' => $request->input('name'),
            'slug' => $slug,
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),

            // Update or clear the subsidiary association.
            'subsidiary_id' => $request->input('subsidiary_id') ?: null,

            'features' => $features,
            'status' => $request->boolean('status') ? 1 : 0,
            'sort_order' => $request->input('sort_order', 0),

            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),

            'og_title' => $request->input('og_title'),
            'og_description' => $request->input('og_description'),

            'twitter_title' => $request->input('twitter_title'),
            'twitter_description' => $request->input('twitter_description'),
        ]);

        return redirect()
            ->route('service.index')
            ->with('success', 'Service has been updated successfully.');
    }

    /**
     * Delete service.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('service.index')
            ->with('success', 'Service has been deleted successfully.');
    }

    /**
     * Public service listing.
     */
    public function publicIndex()
    {
        $services = Service::with('subsidiary')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('frontend.services.index', compact('services'));
    }

    /**
     * Public service detail.
     */
    public function show(string $slug)
    {
        $service = Service::with('subsidiary')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.services.show', compact('service'));
    }
}
