@extends('layouts.app')

@section('title', __('app.webshop'))

@section('content')
<div class="container">
    <div class="container mt-2 mb-5">
        <div class="search-container position-relative">
            <input type="text" id="product-search" class="form-control search-input" placeholder="Search products...">
            <img src="{{ asset('icons/search.png') }}" alt="Search Icon" class="search-icon">
        </div>
        
    </div>
    
    <div class="row">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</div>
@endsection

