<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('vacancy')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('candidate_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('vacancy', function ($vacancyQuery) use ($search) {
                        $vacancyQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $applications = $query->paginate(20)->withQueryString();

        return view(
            'backend.job_applications.index',
            compact('applications')
        );
    }

    public function show(JobApplication $jobApplication)
    {
        $jobApplication->load('vacancy');

        return view(
            'backend.job_applications.show',
            compact('jobApplication')
        );
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'submitted',
                    'under_review',
                    'shortlisted',
                    'rejected',
                    'hired',
                ]),
            ],
            'admin_notes' => ['nullable', 'string', 'max:10000'],
        ]);

        $jobApplication->update($validated);

        return back()->with(
            'success',
            __('Application updated successfully.')
        );
    }

    public function downloadCv(JobApplication $jobApplication)
    {
        abort_unless(
            Storage::disk('local')->exists($jobApplication->cv_path),
            404
        );

        return Storage::disk('local')->download(
            $jobApplication->cv_path,
            basename($jobApplication->cv_original_name ?: 'candidate-cv')
        );
    }
}
