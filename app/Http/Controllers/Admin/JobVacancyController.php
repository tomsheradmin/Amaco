<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::withCount('applications')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vacancies = $query->paginate(15)->withQueryString();

        return view('backend.job_vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        $vacancy = new JobVacancy();

        return view('backend.job_vacancies.create', compact('vacancy'));
    }

    public function store(Request $request)
    {
        $data = $this->validateVacancy($request);

        $data['created_by'] = Auth::id();
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        JobVacancy::create($data);

        return redirect()
            ->route('job-vacancies.index')
            ->with('success', __('Job vacancy created successfully.'));
    }

    public function edit(JobVacancy $jobVacancy)
    {
        $vacancy = $jobVacancy;

        return view('backend.job_vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $data = $this->validateVacancy($request);

        if ($jobVacancy->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug(
                $data['title'],
                $jobVacancy->id
            );
        }

        if ($data['status'] === 'published') {
            $data['published_at'] ??= $jobVacancy->published_at ?? now();
        } else {
            $data['published_at'] = null;
        }

        $jobVacancy->update($data);

        return redirect()
            ->route('job-vacancies.index')
            ->with('success', __('Job vacancy updated successfully.'));
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        // Also remove privately stored CVs for this vacancy.
        foreach ($jobVacancy->applications as $application) {
            if ($application->cv_path) {
                \Illuminate\Support\Facades\Storage::disk('local')
                    ->delete($application->cv_path);
            }
        }

        $jobVacancy->delete();

        return redirect()
            ->route('job-vacancies.index')
            ->with('success', __('Job vacancy deleted successfully.'));
    }

    private function validateVacancy(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],

            'employment_type' => [
                'required',
                Rule::in([
                    'full_time',
                    'part_time',
                    'contract',
                    'temporary',
                    'internship',
                ]),
            ],

            'workplace_type' => [
                'required',
                Rule::in(['onsite', 'remote', 'hybrid']),
            ],

            'description' => ['required', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'salary_range' => ['nullable', 'string', 'max:255'],
            'application_deadline' => ['nullable', 'date'],

            'is_featured' => ['nullable', 'boolean'],
            'status' => [
                'required',
                Rule::in(['draft', 'published', 'closed']),
            ],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'job';
        $slug = $base;
        $counter = 1;

        while (
            JobVacancy::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
