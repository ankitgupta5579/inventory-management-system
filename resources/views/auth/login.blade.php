@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="card p-4">
    <h4 class="text-center mb-4">Login to your account</h4>

    @if($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3 mb-0">No account? <a href="{{ route('register') }}">Register</a></p>
</div>
@endsection