@extends('layouts.employer')

@section('content')
<div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1" style="font-size:1.6rem; font-weight:600; color:#333;">Edit Job: {{ $job->title }}</h1>
        <p class="mb-0" style="color: #666;">Update your job posting details</p>
    </div>
    <div>
        <a href="{{ route('employer.jobs') }}" class="btn btn-secondary">&larr; Back to My Jobs</a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3>Edit Job Posting</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $job->title) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="6" required>{{ old('description', $job->description) }}</textarea>
            </div>
            <div class="form-row d-flex gap-3">
                <div class="form-group" style="flex:1;">
                    <label for="company">Company</label>
                    <input id="company" name="company" type="text" value="{{ old('company', $job->company) }}" class="form-control" required>
                </div>
                <div class="form-group" style="flex:1;">
                    <label for="location">Location</label>
                    <input id="location" name="location" type="text" value="{{ old('location', $job->location) }}" class="form-control" required>
                </div>
            </div>
            <div class="form-row d-flex gap-3">
                <div class="form-group" style="flex:1;">
                    <label for="salary_range">Salary Range</label>
                    <input id="salary_range" name="salary_range" type="text" value="{{ old('salary_range', $job->salary_range) }}" class="form-control">
                </div>
                <div class="form-group" style="flex:1;">
                    <label for="employment_type">Employment Type</label>
                    <select id="employment_type" name="employment_type" class="form-control" required>
                        <option value="full_time" @if(old('employment_type',$job->employment_type)==='full_time') selected @endif>Full-time</option>
                        <option value="part_time" @if(old('employment_type',$job->employment_type)==='part_time') selected @endif>Part-time</option>
                        <option value="contract" @if(old('employment_type',$job->employment_type)==='contract') selected @endif>Contract</option>
                        <option value="internship" @if(old('employment_type',$job->employment_type)==='internship') selected @endif>Internship</option>
                    </select>
                </div>
                <div class="form-group" style="flex:1;">
                    <label for="experience_level">Experience Level</label>
                    <select id="experience_level" name="experience_level" class="form-control" required>
                        <option value="entry" @if(old('experience_level',$job->experience_level)==='entry') selected @endif>Entry</option>
                        <option value="mid" @if(old('experience_level',$job->experience_level)==='mid') selected @endif>Mid</option>
                        <option value="senior" @if(old('experience_level',$job->experience_level)==='senior') selected @endif>Senior</option>
                        <option value="executive" @if(old('experience_level',$job->experience_level)==='executive') selected @endif>Executive</option>
                    </select>
                </div>
            </div>
            <div class="form-row d-flex gap-3">
                <div class="form-group" style="flex:1;">
                    <label for="required_skills">Required Skills (comma separated)</label>
                    <input id="required_skills" name="required_skills" type="text" value="{{ old('required_skills', is_array($job->required_skills) ? implode(',', $job->required_skills) : $job->required_skills) }}" class="form-control">
                </div>
                <div class="form-group" style="flex:1;">
                    <label for="benefits">Benefits (comma separated)</label>
                    <input id="benefits" name="benefits" type="text" value="{{ old('benefits', is_array($job->benefits) ? implode(',', $job->benefits) : $job->benefits) }}" class="form-control">
                </div>
            </div>
            <div class="form-row d-flex gap-3">
                <div class="form-group" style="flex:1;">
                    <label for="application_deadline">Application Deadline</label>
                    <input id="application_deadline" name="application_deadline" type="date" value="{{ old('application_deadline', optional($job->application_deadline)->format('Y-m-d')) }}" class="form-control">
                </div>
                <div class="form-group" style="flex:1;">
                    <label for="is_active">Active?</label><br>
                    <input id="is_active" name="is_active" type="checkbox" value="1" @if(old('is_active', $job->is_active)) checked @endif>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="submit" class="btn btn-primary">Update Job</button>
                <form method="POST" action="{{ route('employer.jobs.delete', $job) }}" onsubmit="return confirm('Are you sure you want to delete this job?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Job</button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
