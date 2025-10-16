<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - JobConnect Admin</title>
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
                <h1>Manage Users</h1>
                <p>View and manage all registered users</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($user->user_type == 'admin') badge-danger
                                                    @elseif($user->user_type == 'employer') badge-info
                                                    @else badge-success @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if(!$user->isAdmin())
                                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Admin User</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="pagination">
                                {{ $users->links() }}
                            </div>
                        @endif
                    @else
                        <p class="text-center">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
