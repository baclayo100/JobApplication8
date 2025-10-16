<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job - JobConnect</title>
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
                <h1>Post a New Job</h1>
                <p>Create a job posting to attract qualified candidates</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('employer.jobs.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Job Title *</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Job Description *</label>
                            <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company">Company Name *</label>
                            <input type="text" id="company" name="company" class="form-control @error('company') is-invalid @enderror" 
                                   value="{{ old('company') }}" required>
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Location *</label>
                            <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                                   value="{{ old('location') }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="salary_range">Salary Range</label>
                            <input type="text" id="salary_range" name="salary_range" class="form-control @error('salary_range') is-invalid @enderror" 
                                   value="{{ old('salary_range') }}" placeholder="e.g., $50,000 - $70,000">
                            @error('salary_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="employment_type">Employment Type *</label>
                            <select id="employment_type" name="employment_type" class="form-control @error('employment_type') is-invalid @enderror" required>
                                <option value="">Select employment type</option>
                                <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="experience_level">Experience Level *</label>
                            <select id="experience_level" name="experience_level" class="form-control @error('experience_level') is-invalid @enderror" required>
                                <option value="">Select experience level</option>
                                <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="mid" {{ old('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive Level</option>
                            </select>
                            @error('experience_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="application_deadline">Application Deadline</label>
                            <input type="date" id="application_deadline" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" 
                                   value="{{ old('application_deadline') }}">
                            @error('application_deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">Post Job</button>
                            <a href="{{ route('employer.dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
