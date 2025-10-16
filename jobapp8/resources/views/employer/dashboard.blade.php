<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - JobConnect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('landing') }}" class="logo">JobConnect</a>
            <ul class="nav-links">
                <li><a href="{{ route('employer.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('employer.jobs.create') }}">Post Job</a></li>
                <li><a href="{{ route('employer.jobs') }}">My Jobs</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Employer Dashboard</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $jobPostings->count() }}</div>
                    <div class="stat-label">Total Jobs Posted</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $jobPostings->where('is_active', true)->count() }}</div>
                    <div class="stat-label">Active Jobs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $totalApplications }}</div>
                    <div class="stat-label">Total Applications</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $jobPostings->where('is_active', false)->count() }}</div>
                    <div class="stat-label">Inactive Jobs</div>
                </div>
            </div>

            <!-- Recent Job Postings -->
            <div class="card">
                <div class="card-header">
                    <h3>Recent Job Postings</h3>
                </div>
                <div class="card-body">
                    @if($jobPostings->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Applications</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobPostings->take(5) as $job)
                                        <tr>
                                            <td>{{ $job->title }}</td>
                                            <td>{{ $job->company }}</td>
                                            <td>{{ $job->location }}</td>
                                            <td>
                                                <span class="badge {{ $job->is_active ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $job->applications->count() }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-primary">Edit</a>
                                                    <a href="{{ route('employer.jobs.applications', $job) }}" class="btn btn-secondary">Applications</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">You haven't posted any jobs yet. <a href="{{ route('employer.jobs.create') }}">Post your first job</a> to get started!</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">Post New Job</a>
                        <a href="{{ route('employer.jobs') }}" class="btn btn-secondary">Manage Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
