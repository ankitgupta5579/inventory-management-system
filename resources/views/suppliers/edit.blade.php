@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<div class="card p-4">
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf @method('PUT')
        @include('suppliers._form')
    </form>
</div>
@endsection