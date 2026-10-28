@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="card p-4">
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf @method('PUT')
        @include('products._form')
    </form>
</div>
@endsection