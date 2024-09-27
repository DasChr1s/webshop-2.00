<!-- resources/views/admin/adminDashboard.blade.php -->

@extends('layouts.admin-layout')

@section('admin-content')
    <h1>Welcome, {{ Auth::user()->name }}!</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-primary">
                <div class="card-header">Gastbestellungen Heute</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $todayOrdersCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success">
                <div class="card-header">Bestellungen Heute</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $todayOrdersCount }}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection