{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Edit Category</h2>
            <a href="{{ route('admin.categories.index') }}"
               class="text-sm text-pink-600 hover:text-pink-700 font-medium transition-all">← Back</a>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
              class="space-y-6" id="editCategoryForm">
            @csrf
            @method('PUT')

            {{-- الاسم --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                       placeholder="Enter category name" required>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Parent Category --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category (Optional)</label>
                <select name="parent_id"
                        class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition bg-white">
                    <option value="">— No Parent (Main Category) —</option>
                    @foreach($categories as $parent)
                        @if($parent->id !== $category->id)
                            <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- الوصف --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition resize-none"
                          placeholder="Enter short description">{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- الصورة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>

                @if($category->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/'.$category->image) }}"
                             class="w-28 h-28 rounded-xl border border-pink-100 object-cover shadow-sm">
                    </div>
                @endif

                <input type="file" name="image" id="imageInput"
                       class="block w-full text-sm text-gray-700 border border-pink-200 rounded-xl cursor-pointer bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 file:bg-pink-100 file:text-pink-700 file:font-semibold file:rounded-lg file:border-0 file:px-4 file:py-2 hover:file:bg-pink-200 transition">
                @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- الأزرار --}}
            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-xl font-medium shadow-sm transition text-center">
                    Cancel
                </a>
                <button type="submit" id="updateBtn"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span id="updateText">Update Category</span>
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ optional loading effect --}}
<script>
    document.getElementById('editCategoryForm').addEventListener('submit', function () {
        document.getElementById('updateText').textContent = 'Updating...';
        document.getElementById('loadingIcon').classList.remove('hidden');
    });
</script>
@endsection
