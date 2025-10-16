<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard - JobConnect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('landing') }}" class="logo">JobConnect</a>
            <ul class="nav-links">
                <li><a href="{{ route('job-seeker.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('job-seeker.jobs') }}">Browse Jobs</a></li>
                <li><a href="{{ route('job-seeker.applications') }}">My Applications</a></li>
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
                <p>Job Seeker Dashboard</p>
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
                    <div class="stat-number">{{ $applications->count() }}</div>
                    <div class="stat-label">Total Applications</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $applications->where('status', 'pending')->count() }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $applications->where('status', 'reviewed')->count() }}</div>
                    <div class="stat-label">Under Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $applications->where('status', 'accepted')->count() }}</div>
                    <div class="stat-label">Accepted</div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="card">
                <div class="card-header">
                    <h3>Recent Applications</h3>
                </div>
                <div class="card-body">
                    @if($applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Applied Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications->take(5) as $application)
                                        <tr>
                                            <td>{{ $application->jobPosting->title }}</td>
                                            <td>{{ $application->jobPosting->company }}</td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($application->status == 'accepted') badge-success
                                                    @elseif($application->status == 'rejected') badge-danger
                                                    @elseif($application->status == 'reviewed') badge-info
                                                    @else badge-warning @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('job-seeker.job.show', $application->jobPosting) }}" class="btn btn-primary">View Job</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($applications->count() > 5)
                            <div class="text-center">
                                <a href="{{ route('job-seeker.applications') }}" class="btn btn-secondary">View All Applications</a>
                            </div>
                        @endif
                    @else
                        <p class="text-center">You haven't applied to any jobs yet. <a href="{{ route('job-seeker.jobs') }}">Browse available jobs</a> to get started!</p>
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
                        <a href="{{ route('job-seeker.jobs') }}" class="btn btn-primary">Browse Jobs</a>
                        <a href="{{ route('job-seeker.applications') }}" class="btn btn-secondary">View Applications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
