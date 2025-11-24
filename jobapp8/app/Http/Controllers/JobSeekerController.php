<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobSeekerController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $applications = $user->jobApplications()->with('jobPosting')->latest()->get();
        
        return view('job-seeker.dashboard', compact('applications'));
    }

    public function browseJobs(): View
    {
        $jobs = JobPosting::active()
            ->with('employer')
            ->latest()
            ->paginate(10);
            
        return view('job-seeker.browse-jobs', compact('jobs'));
    }

    public function showJob(JobPosting $job): View
    {
        $hasApplied = Auth::user()->jobApplications()
            ->where('job_posting_id', $job->id)
            ->exists();
            
        return view('job-seeker.job-details', compact('job', 'hasApplied'));
    }

    public function apply(Request $request, JobPosting $job)
    {
        $user = Auth::user();
        
        // Check if user already applied
        if ($user->jobApplications()->where('job_posting_id', $job->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        JobApplication::create([
            'job_seeker_id' => $user->id,
            'job_posting_id' => $job->id,
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $resumePath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    public function applications(): View
    {
        $applications = Auth::user()->jobApplications()
            ->with('jobPosting.employer')
            ->latest()
            ->paginate(10);
            
        return view('job-seeker.applications', compact('applications'));
    }

    public function withdrawApplication(JobApplication $application)
    {
        $user = Auth::user();
        if ($application->job_seeker_id !== $user->id) {
            abort(403);
        }
        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending applications can be withdrawn.');
        }
        $application->delete();
        return redirect()->back()->with('success', 'Application withdrawn successfully.');
    }
}
