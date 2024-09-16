@extends('layouts.app')

@section('content')
    <h1>Warenkorb</h1>
    @if ($products->isEmpty())
        <p>Ihr Warenkorb ist leer.</p>
    @else
        <ul>
            @foreach ($products as $product)
                <li>
                    {{ $product->name }} - €{{ number_format($product->price, 2) }} x {{ $cart[$product->id] }}
                </li>
            @endforeach
        </ul>
    @endif
@endsection
