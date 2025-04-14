
@extends('layouts.app')

@section('content')
    <!-- Navbar -->
    <x-navbar />

    <!-- Hero Section -->
    <x-hero-section />
    <br>

    <!-- Sección Descubre -->
    <x-discover-section :randomEvents="$randomEvents" />

    <!-- Footer -->
    <x-footer />
@endsection
