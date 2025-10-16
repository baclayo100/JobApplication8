<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs - JobConnect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('landing') }}" class="logo">JobConnect</a>
            <ul class="nav-links">
                <li><a href="{{ route('employer.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('employer.jobs.create') }}">Post Job</a></li>
                <li><a href="{{ route('employer.jobs') }}">Manage Jobs</a></li>
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
        <div class="dashboard-header">
            <h1>Manage All Job Postings</h1>
            <p>List of all jobs you have posted.</p>
        </div>
        <div class="card">
            <div class="card-body">
                @if($jobPostings->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Posted On</th>
                                    <th>Status</th>
                                    <th>Applications</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobPostings as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->company }}</td>
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
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
    </div>
</body>
</html>
