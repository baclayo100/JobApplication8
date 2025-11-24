<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - JobConnect</title>
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
                <div class="d-flex align-items-center gap-3">
                    @if($job->company_logo && !empty($job->company_logo))
                        @php
                            $logoPath = \Illuminate\Support\Facades\Storage::url($job->company_logo);
                        @endphp
                        <img src="{{ $logoPath }}" alt="{{ $job->company }} Logo" style="max-width: 100px; max-height: 100px; object-fit: contain; border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: white;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="width: 100px; height: 100px; border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: #f8f9fa; display: none; align-items: center; justify-content: center; color: #999; font-size: 0.8rem; text-align: center;">
                            No Logo
                        </div>
                    @else
                        <div style="width: 100px; height: 100px; border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.8rem; text-align: center;">
                            No Logo
                        </div>
                    @endif
                    <div>
                        <h1>{{ $job->title }}</h1>
                        <p>{{ $job->company }} • {{ $job->location }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="feature-grid">
                <!-- Job Details -->
                <div class="card">
                    <div class="card-header">
                        <h3>Job Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Company:</strong> {{ $job->company }}
                        </div>
                        <div class="mb-3">
                            <strong>Location:</strong> {{ $job->location }}
                        </div>
                        @if($job->salary_range)
                            <div class="mb-3">
                                <strong>Salary:</strong> ₱{{ $job->salary_range }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <strong>Employment Type:</strong> 
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Experience Level:</strong> 
                            <span class="badge badge-secondary">{{ ucfirst($job->experience_level) }}</span>
                        </div>
                        @if($job->application_deadline)
                            <div class="mb-3">
                                <strong>Application Deadline:</strong> {{ $job->application_deadline->format('M d, Y') }}
                            </div>
                        @endif
                        <div class="mb-3">
                            <strong>Posted:</strong> {{ $job->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="card">
                    <div class="card-header">
                        <h3>Job Description</h3>
                    </div>
                    <div class="card-body">
                        <div style="white-space: pre-line;">{{ $job->description }}</div>
                        
                        @if($job->required_skills && count($job->required_skills) > 0)
                            <div class="mt-4">
                                <strong>Required Skills:</strong>
                                <div class="d-flex gap-2 mt-2">
                                    @foreach($job->required_skills as $skill)
                                        <span class="badge badge-info">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($job->benefits && count($job->benefits) > 0)
                            <div class="mt-4">
                                <strong>Benefits:</strong>
                                <ul class="mt-2">
                                    @foreach($job->benefits as $benefit)
                                        <li>{{ $benefit }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            @if(!$hasApplied)
                <div class="card">
                    <div class="card-header">
                        <h3>Apply for this Position</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('job-seeker.job.apply', $job) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="cover_letter">Cover Letter</label>
                                <textarea id="cover_letter" name="cover_letter" rows="6" class="form-control @error('cover_letter') is-invalid @enderror" 
                                          placeholder="Tell us why you're interested in this position...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="resume">Resume (PDF, DOC, DOCX)</label>
                                <input type="file" id="resume" name="resume" class="form-control @error('resume') is-invalid @enderror" 
                                       accept=".pdf,.doc,.docx">
                                @error('resume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-primary">Submit Application</button>
                                <a href="{{ route('job-seeker.jobs') }}" class="btn btn-secondary">Back to Jobs</a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <h3>Application Submitted</h3>
                        <p>You have already applied for this position. We'll review your application and get back to you soon!</p>
                        <a href="{{ route('job-seeker.jobs') }}" class="btn btn-primary">Back to Jobs</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
