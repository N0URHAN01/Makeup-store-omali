@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-4">Welcome, Admin!</h1>
        <p class="text-gray-700">This is your dashboard.</p>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </div>
@endsection
