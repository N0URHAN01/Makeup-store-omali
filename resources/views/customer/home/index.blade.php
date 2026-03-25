@extends('customer.layouts.app')

@section('title','Home')

@section('content')

    {{-- Hero --}}
    @include('customer.home.sections.hero')

    {{-- Categories --}}
    @include('customer.home.sections.categories')

    {{-- Products Section --}}
    @include('customer.home.sections.products')

@endsection