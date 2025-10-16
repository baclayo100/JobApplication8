<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'job_seekers' => User::where('user_type', 'job_seeker')->count(),
            'employers' => User::where('user_type', 'employer')->count(),
            'total_jobs' => JobPosting::count(),
            'active_jobs' => JobPosting::active()->count(),
            'total_applications' => JobApplication::count(),
        ];

        $recentJobs = JobPosting::with('employer')->latest()->limit(5)->get();
        $recentApplications = JobApplication::with(['jobSeeker', 'jobPosting'])->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentJobs', 'recentApplications'));
    }

    public function users(): View
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function jobs(): View
    {
        $jobs = JobPosting::with('employer')->latest()->paginate(15);
        return view('admin.jobs', compact('jobs'));
    }

    public function applications(): View
    {
        $applications = JobApplication::with(['jobSeeker', 'jobPosting.employer'])
            ->latest()
            ->paginate(15);
            
        return view('admin.applications', compact('applications'));
    }

    public function toggleJobStatus(JobPosting $job)
    {
        $job->update(['is_active' => !$job->is_active]);
        
        $status = $job->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Job {$status} successfully!");
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }
        
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function deleteJob(JobPosting $job)
    {
        $job->delete();
        return redirect()->back()->with('success', 'Job deleted successfully!');
    }
}
