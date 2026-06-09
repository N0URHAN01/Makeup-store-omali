@extends('customer.layouts.app')

@section('title','Home')

@section('content')

    {{-- Hero --}}
    @include('customer.home.sections.hero')

    

      {{-- Categories --}}
      @include('customer.home.sections.categories')

    {{-- Offers --}}
      @include('customer.home.sections.offers')

      {{-- Products Section --}}
      @include('customer.home.sections.products')

      {{-- About Us --}}
      @include('customer.home.sections.aboutus')

      {{-- Reviews --}}
      @include('customer.home.sections.reviews')

          {{--footer--}}
      @include('customer.home.sections.footer')
@endsection