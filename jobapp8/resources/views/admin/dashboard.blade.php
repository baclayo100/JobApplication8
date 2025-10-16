<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JobConnect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('landing') }}" class="logo">JobConnect</a>
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}">Users</a></li>
                <li><a href="{{ route('admin.jobs') }}">Jobs</a></li>
                <li><a href="{{ route('admin.applications') }}">Applications</a></li>
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
                <h1>Admin Dashboard</h1>
                <p>System Overview & Management</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Statistics Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_users'] }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['job_seekers'] }}</div>
                    <div class="stat-label">Job Seekers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['employers'] }}</div>
                    <div class="stat-label">Employers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_jobs'] }}</div>
                    <div class="stat-label">Total Jobs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['active_jobs'] }}</div>
                    <div class="stat-label">Active Jobs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total_applications'] }}</div>
                    <div class="stat-label">Total Applications</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="feature-grid">
                <!-- Recent Jobs -->
                <div class="card">
                    <div class="card-header">
                        <h3>Recent Job Postings</h3>
                    </div>
                    <div class="card-body">
                        @if($recentJobs->count() > 0)
                            @foreach($recentJobs as $job)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $job->title }}</strong><br>
                                        <small class="text-muted">{{ $job->company }} - {{ $job->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span class="badge {{ $job->is_active ? 'badge-success' : 'badge-warning' }}">
                                            {{ $job->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <a href="{{ route('admin.jobs') }}" class="btn btn-sm btn-secondary">View</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No recent job postings.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="card">
                    <div class="card-header">
                        <h3>Recent Applications</h3>
                    </div>
                    <div class="card-body">
                        @if($recentApplications->count() > 0)
                            @foreach($recentApplications as $application)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $application->jobSeeker->name }}</strong><br>
                                        <small class="text-muted">{{ $application->jobPosting->title }} - {{ $application->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <span class="badge 
                                            @if($application->status == 'accepted') badge-success
                                            @elseif($application->status == 'rejected') badge-danger
                                            @elseif($application->status == 'reviewed') badge-info
                                            @else badge-warning @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                        <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-secondary">View</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No recent applications.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Manage Users</a>
                        <a href="{{ route('admin.jobs') }}" class="btn btn-secondary">Manage Jobs</a>
                        <a href="{{ route('admin.applications') }}" class="btn btn-secondary">View Applications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
