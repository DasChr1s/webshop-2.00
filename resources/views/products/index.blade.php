@extends('layouts.app')

@section('title', __('app.webshop'))

@section('content')
    <div class="container">
        
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2>{{ __('app.discoverProducts') }}</h2>
                    <p class="lead">{{ __('app.discoverText') }}</p>
                   
                </div>
            </div>
        </div>
        
        <div class="row">
            
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
@endsection
