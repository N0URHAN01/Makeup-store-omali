@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 shadow-lg rounded-2xl border border-gray-200">

    {{-- HEADER --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Add Governorate</h1>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.governorates.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300"
                   value="{{ old('name') }}" required>
            @error('name') 
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Shipping Cost</label>
            <input type="number" name="shipping_cost" step="0.01" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300"
                   value="{{ old('shipping_cost') }}" required>
            @error('shipping_cost') 
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.governorates.index') }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
               Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg shadow transition">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
