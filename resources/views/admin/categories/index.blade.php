@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Manage Categories</h2>
        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium shadow-md hover:shadow-lg transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Category
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-300 text-green-800 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md border border-pink-100 p-5">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Existing Categories</h3>

        <div class="overflow-x-auto rounded-xl border border-pink-50">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Parent</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $key => $category)
                        <tr class="border-b hover:bg-pink-50/50 transition-all">
                            <td class="px-4 py-3">
                                {{ $key + 1 + ($categories->currentPage() - 1) * $categories->perPage() }}
                            </td>

                            {{-- الصورة --}}
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.categories.show', $category->id) }}" class="block">
                                    @if($category->image)
                                        <img src="{{ asset('storage/'.$category->image) }}"
                                             class="w-10 h-10 rounded-lg object-cover border border-pink-100 shadow-sm hover:scale-105 transition-transform duration-200">
                                    @else
                                        <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </a>
                            </td>

                            {{-- الاسم --}}
                            <td class="px-4 py-3 font-medium text-gray-800">
                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                   class="text-pink-600 hover:text-pink-700 hover:underline transition-all duration-150">
                                    {{ $category->name }}
                                </a>
                            </td>

                            {{-- الفئة الرئيسية --}}
                            <td class="px-4 py-3 text-gray-600 italic">
                                {{ $category->parent ? $category->parent->name : '—' }}
                            </td>

                            {{-- الوصف --}}
                            <td class="px-4 py-3">
                                {{ Str::limit($category->description, 40) }}
                            </td>

                            {{-- الأكشنز --}}
                            <td class="px-4 py-3 text-center flex justify-center space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="bg-pink-100 hover:bg-pink-200 text-pink-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                    Edit
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
