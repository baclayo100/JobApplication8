@extends('layouts.app')

@section('content')
<section class="card auth">
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.post') }}" class="form">
        @csrf
        <div class="form__group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form__group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div class="form__row">
            <label class="checkbox">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button type="submit" class="btn btn--primary">Login</button>
        </div>
    </form>
</section>
@endsection


