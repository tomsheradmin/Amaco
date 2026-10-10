<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareersController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::published()
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('careers.index', compact('vacancies'));
    }

    public function show(string $slug)
    {
        $vacancy = JobVacancy::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('careers.show', compact('vacancy'));
    }

    public function apply(Request $request, string $slug)
    {
        $vacancy = JobVacancy::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'candidate_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'cover_letter' => ['nullable', 'string', 'max:10000'],

            // Restrict uploads to common CV formats.
            'cv' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
        ]);

        $file = $request->file('cv');

        // Keep CV files on a private disk; never expose a public file URL.
        $path = $file->store('job-applications/cvs', 'local');

        try {
            JobApplication::create([
                'job_vacancy_id' => $vacancy->id,
                'candidate_name' => $validated['candidate_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'cover_letter' => $validated['cover_letter'] ?? null,
                'cv_path' => $path,
                'cv_original_name' => $file->getClientOriginalName(),
                'status' => 'submitted',
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($path);

            throw $exception;
        }

        return redirect()
            ->route('careers.show', $vacancy->slug)
            ->with('success', __('Your application has been submitted successfully.'));
    }
}
