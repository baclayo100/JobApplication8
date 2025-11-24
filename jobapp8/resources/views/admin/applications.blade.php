<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications - JobConnect Admin</title>
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
                <h1>Manage Applications</h1>
                <p>View and manage all job applications</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->jobSeeker->name ?? '-' }}</td>
                                            <td>{{ $application->jobPosting->title ?? '-' }}</td>
                                            <td>{{ $application->jobPosting->company ?? '-' }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($application->status == 'accepted') badge-success
                                                    @elseif($application->status == 'rejected') badge-danger
                                                    @elseif($application->status == 'reviewed') badge-info
                                                    @else badge-warning @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td style="max-width:300px; white-space:pre-wrap;">{{ $application->notes ?? '-' }}</td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($applications->hasPages())
                            <div class="pagination">
                                {{ $applications->links() }}
                            </div>
                        @endif
                    @else
                        <p class="text-center">No applications found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
