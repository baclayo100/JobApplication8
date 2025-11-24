@extends('layouts.employer')

@section('content')
    <div class="dashboard-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1" style="font-size:1.6rem; font-weight:600; color:#333;">Applications for: {{ $job->title }}</h1>
            <p class="mb-0" style="color: #666;">Manage all applicants for this position</p>
        </div>
        <div>
            <a href="{{ route('employer.jobs') }}" class="btn btn-secondary">&larr; Back to My Jobs</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 style="margin-bottom:0">Job Applications</h3>
        </div>
        <div class="card-body">
            @if($applications->isEmpty())
                <div class="alert alert-info mb-0">No job applications yet.</div>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>File</th>
                        <th>Applied At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->jobSeeker->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{
                                    $application->status === 'accepted' ? 'badge-success' :
                                    ($application->status === 'pending' ? 'badge-warning' :
                                    ($application->status === 'rejected' ? 'badge-danger' : 'badge-info'))
                                }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->notes ?? '-' }}</td>
                            <td>
                                @if(!empty($application->resume_path))
                                    @php $resumeUrl = \Illuminate\Support\Facades\Storage::url($application->resume_path); @endphp
                                    <a href="{{ $resumeUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ $resumeUrl }}" download class="btn btn-sm btn-outline-secondary">Download</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($application->status === 'pending')
                                    <div class="d-flex gap-2 align-items-center">
                                        <form action="{{ route('employer.applications.update', $application) }}" method="POST" class="d-flex gap-2 align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <input type="text" name="notes" class="form-control" placeholder="Notes" style="width: 120px; font-size: 0.98em;" />
                                            <button type="submit" class="btn btn-primary">Accept</button>
                                        </form>
                                        <form action="{{ route('employer.applications.update', $application) }}" method="POST" class="d-flex gap-2 align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <input type="text" name="notes" class="form-control" placeholder="Notes" style="width: 120px; font-size: 0.98em;" />
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                        <form action="{{ route('employer.applications.update', $application) }}" method="POST" class="d-flex gap-2 align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="reviewed">
                                            <input type="text" name="notes" class="form-control" placeholder="Notes" style="width: 120px; font-size: 0.98em;" />
                                            <button type="submit" class="btn btn-secondary">Review</button>
                                        </form>
                                    </div>
                                @else
                                    <span style="font-size: .97em; color: #64748b;">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
@endsection
