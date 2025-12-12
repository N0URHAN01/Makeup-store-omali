{{-- resources/views/admin/categories/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Category Details</h2>
            <a href="{{ route('admin.categories.index') }}"
               class="text-sm text-pink-600 hover:text-pink-700 font-medium transition-all">← Back</a>
        </div>

        <div class="flex flex-col md:flex-row md:items-start gap-8">
            {{-- الصورة --}}
            <div class="flex-shrink-0">
                @if($category->image)
                    <img src="{{ asset('storage/'.$category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="w-48 h-48 md:w-56 md:h-56 rounded-2xl object-cover shadow-md border border-pink-100">
                @else
                    <div class="w-48 h-48 md:w-56 md:h-56 flex items-center justify-center bg-pink-50 rounded-2xl text-pink-400 font-medium border border-pink-100">
                        No Image
                    </div>
                @endif
            </div>

            {{-- التفاصيل --}}
            <div class="flex-1 space-y-5">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $category->name }}</h3>

                {{-- ✅ Parent Category --}}
                <p class="text-sm">
                    <span class="font-semibold text-gray-700">Parent Category:</span>
                    @if($category->parent)
                        <span class="text-pink-600">{{ $category->parent->name }}</span>
                    @else
                        <span class="text-gray-500">Main Category (No Parent)</span>
                    @endif
                </p>

                <p class="text-gray-600 leading-relaxed">
                    {{ $category->description ?? 'No description provided.' }}
                </p>

                <div class="text-sm text-gray-500 space-y-1.5">
                    <p><span class="font-semibold text-gray-700">Slug:</span> {{ $category->slug ?? 'N/A' }}</p>
                    <p><span class="font-semibold text-gray-700">Created At:</span> {{ $category->created_at->format('d M Y, h:i A') }}</p>
                    <p><span class="font-semibold text-gray-700">Updated At:</span> {{ $category->updated_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- الأزرار --}}
        <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-xl font-medium shadow-sm transition text-center">
                Back
            </a>

            <a href="{{ route('admin.categories.edit', $category->id) }}"
               class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all text-center">
                Edit
            </a>

            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this category?')" class="text-center">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all w-full sm:w-auto">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
