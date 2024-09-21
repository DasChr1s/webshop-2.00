@extends('layouts.app')

@section('content')
    <div class="order-form-container">

        <!-- Zurück Button -->
        <div class="form-group">
            <a href="{{ route('cart.show') }}" class="btn back-link">Zurück zum Warenkorb</a>
        </div>

        <h2>Bestelldaten</h2>

        <!-- Formular für Email und Adresse -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            <!-- Name Eingabefeld -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- E-Mail Eingabefeld -->
            <div class="form-group">
                <label for="email">E-Mail:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Adress-Eingabefelder -->
            <div class="form-group">
                <label for="street">Straße:</label>
                <input type="text" id="street" name="street" class="form-control" value="{{ old('street') }}" required>
                @error('street')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">Stadt:</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required>
                @error('city')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="postal_code">Postleitzahl:</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                @error('postal_code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="country">Land:</label>
                <input type="text" id="country" name="country" class="form-control" value="{{ old('country') }}" required>
                @error('country')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

           
        </form>
         <!-- Submit Button -->
         <div class="form-group">
            <button type="submit" class="btn btn-primary">Bestellung aufgeben</button>
        </div>
    </div>
@endsection
