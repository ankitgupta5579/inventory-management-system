@extends('layouts.app')
@section('title', 'Add Product')

@section('content')
<div class="card p-4">
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('products._form')
    </form>
</div>
@endsection