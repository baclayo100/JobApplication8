@extends('layouts.app')

@section('content')
<section class="card">
    <h1>Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}.</p>
    <p>This is your simple protected dashboard.</p>
</section>
@endsection


