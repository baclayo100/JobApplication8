<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AdminController;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected dashboard redirect
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Job Seeker routes
Route::middleware(['auth', 'job.seeker'])->group(function () {
    Route::get('/job-seeker/dashboard', [JobSeekerController::class, 'dashboard'])->name('job-seeker.dashboard');
    Route::get('/job-seeker/jobs', [JobSeekerController::class, 'browseJobs'])->name('job-seeker.jobs');
    Route::get('/job-seeker/jobs/{job}', [JobSeekerController::class, 'showJob'])->name('job-seeker.job.show');
    Route::post('/job-seeker/jobs/{job}/apply', [JobSeekerController::class, 'apply'])->name('job-seeker.job.apply');
    Route::get('/job-seeker/applications', [JobSeekerController::class, 'applications'])->name('job-seeker.applications');
});

// Employer routes
Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::get('/employer/jobs/create', [EmployerController::class, 'createJob'])->name('employer.jobs.create');
    Route::post('/employer/jobs', [EmployerController::class, 'storeJob'])->name('employer.jobs.store');
    Route::get('/employer/jobs/{job}/edit', [EmployerController::class, 'editJob'])->name('employer.jobs.edit');
    Route::put('/employer/jobs/{job}', [EmployerController::class, 'updateJob'])->name('employer.jobs.update');
    Route::get('/employer/jobs/{job}/applications', [EmployerController::class, 'applications'])->name('employer.jobs.applications');
    Route::put('/employer/applications/{application}', [EmployerController::class, 'updateApplicationStatus'])->name('employer.applications.update');
    Route::get('/employer/jobs', [EmployerController::class, 'index'])->name('employer.jobs');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
    Route::get('/admin/applications', [AdminController::class, 'applications'])->name('admin.applications');
    Route::patch('/admin/jobs/{job}/toggle', [AdminController::class, 'toggleJobStatus'])->name('admin.jobs.toggle');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::delete('/admin/jobs/{job}', [AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
});
