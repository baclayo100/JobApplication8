<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - JobConnect</title>
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
                <h1>Browse Available Jobs</h1>
                <p>Find your next career opportunity</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($jobs->count() > 0)
                @foreach($jobs as $job)
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <div class="d-flex align-items-start gap-3 mb-2">
                                        @if($job->company_logo)
                                            <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company }} Logo" style="max-width: 60px; max-height: 60px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 5px;" onerror="this.style.display='none'">
                                        @endif
                                        <div>
                                            <h3>{{ $job->title }}</h3>
                                            <p class="text-muted">{{ $job->company }} • {{ $job->location }}</p>
                                        </div>
                                    </div>
                                    <p>{{ Str::limit($job->description, 200) }}</p>
                                    <div class="d-flex gap-2 mb-3">
                                        <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                                        <span class="badge badge-secondary">{{ ucfirst($job->experience_level) }}</span>
                                        @if($job->salary_range)
                                            <span class="badge badge-success">{{ $job->salary_range }}</span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted">{{ $job->created_at->format('M d, Y') }}</p>
                                    <a href="{{ route('job-seeker.job.show', $job) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($jobs->hasPages())
                    <div class="pagination">
                        {{ $jobs->links() }}
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <h3>No jobs available</h3>
                        <p>There are currently no job postings available. Check back later!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
