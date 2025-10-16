@extends('layouts.app')

@section('content')
<section class="card auth">
    <h1>Register</h1>
    <form method="POST" action="{{ route('register.post') }}" class="form">
        @csrf
        <div class="form__group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form__group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form__group">
            <label for="user_type">Account Type</label>
            <select id="user_type" name="user_type" required>
                <option value="">Select account type</option>
                <option value="job_seeker" {{ old('user_type') == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                <option value="employer" {{ old('user_type') == 'employer' ? 'selected' : '' }}>Employer</option>
            </select>
            @error('user_type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form__group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form__group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
        <div class="form__row">
            <span></span>
            <button type="submit" class="btn btn--primary">Create account</button>
        </div>
    </form>
</section>
@endsection


