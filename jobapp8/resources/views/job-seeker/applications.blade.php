<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - JobConnect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
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
        <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1" style="font-size:1.6rem; font-weight:600; color:#333;">My Applications</h1>
                <p class="mb-0" style="color: #666;">See all jobs you’ve applied to</p>
            </div>
            <div>
                <a href="{{ route('job-seeker.dashboard') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3 style="margin-bottom:0">Job Applications</h3></div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($applications->isEmpty())
                    <div class="alert alert-info mb-0">You have not applied to any jobs yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                    <th>Employer Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->jobPosting->title ?? '-' }}</td>
                                        <td>{{ $application->jobPosting->company ?? '-' }}</td>
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
                                            @if(in_array($application->status, ['accepted','rejected','reviewed']) && !empty($application->notes))
                                                <div style="max-width:300px; white-space:pre-wrap;">{{ $application->notes }}</div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('job-seeker.job.show', $application->jobPosting) }}" class="btn btn-primary btn-sm">View Job</a>
                                                @if($application->status == 'pending')
                                                    <form method="POST" action="{{ route('job-seeker.applications.withdraw', ['application' => $application->id]) }}" onsubmit="return confirm('Withdraw this application?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Withdraw</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
