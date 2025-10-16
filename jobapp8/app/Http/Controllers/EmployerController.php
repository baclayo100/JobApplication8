<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $jobPostings = $user->jobPostings()->latest()->get();
        $totalApplications = JobApplication::whereHas('jobPosting', function($query) use ($user) {
            $query->where('employer_id', $user->id);
        })->count();
        
        return view('employer.dashboard', compact('jobPostings', 'totalApplications'));
    }

    public function index(): View
    {
        $user = Auth::user();
        $jobPostings = $user->jobPostings()->latest()->get();
        return view('employer.jobs', compact('jobPostings'));
    }

    public function createJob(): View
    {
        return view('employer.create-job');
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'required_skills' => 'nullable|array',
            'benefits' => 'nullable|array',
            'application_deadline' => 'nullable|date|after:today',
        ]);

        $validated['employer_id'] = Auth::id();
        $validated['required_skills'] = $request->input('required_skills', []);
        $validated['benefits'] = $request->input('benefits', []);

        JobPosting::create($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job posted successfully!');
    }

    public function editJob(JobPosting $job): View
    {
        $this->authorize('update', $job);
        return view('employer.edit-job', compact('job'));
    }

    public function updateJob(Request $request, JobPosting $job)
    {
        $this->authorize('update', $job);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'required_skills' => 'nullable|array',
            'benefits' => 'nullable|array',
            'application_deadline' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        $validated['required_skills'] = $request->input('required_skills', []);
        $validated['benefits'] = $request->input('benefits', []);

        $job->update($validated);

        return redirect()->route('employer.dashboard')->with('success', 'Job updated successfully!');
    }

    public function destroyJob(JobPosting $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return redirect()->route('employer.jobs')->with('success', 'Job deleted successfully!');
    }

    public function applications(JobPosting $job): View
    {
        $this->authorize('view', $job);
        
        $applications = $job->applications()
            ->with('jobSeeker')
            ->latest()
            ->get();
            
        return view('employer.job-applications', compact('job', 'applications'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application->jobPosting);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated!');
    }
}
