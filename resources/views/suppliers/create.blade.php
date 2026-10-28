@extends('layouts.app')
@section('title', 'Add Supplier')

@section('content')
<div class="card p-4">
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        @include('suppliers._form')
    </form>
</div>
@endsection