{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Category</h2>
            <a href="{{ route('admin.categories.index') }}"
               class="text-sm text-pink-600 hover:text-pink-700 font-medium transition-all">← Back</a>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6" id="categoryForm">
            @csrf

            {{-- الاسم --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                       placeholder="Enter category name" required>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- الفئة الرئيسية (Parent Category) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category (Optional)</label>
                <select name="parent_id"
                        class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                    <option value="">-- No Parent (Main Category) --</option>
                    @foreach ($categories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- الوصف --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-pink-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition resize-none"
                          placeholder="Enter short description">{{ old('description') }}</textarea>
            </div>

            {{-- الصورة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
                <input type="file" name="image" id="imageInput"
                       class="block w-full text-sm text-gray-700 border border-pink-200 rounded-xl cursor-pointer bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 file:bg-pink-100 file:text-pink-700 file:font-semibold file:rounded-lg file:border-0 file:px-4 file:py-2 hover:file:bg-pink-200 transition">
                @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                {{-- Preview box --}}
                <div id="imagePreview" class="mt-4 hidden relative w-fit mx-auto">
                    <img id="previewImg" src="" alt="Preview"
                         class="max-h-48 rounded-xl border border-pink-100 shadow-sm object-cover">
                    <button type="button" id="removeImage"
                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md">
                        ✕
                    </button>
                </div>
            </div>

            {{-- الأزرار --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    Cancel
                </a>
                <button type="submit" id="saveBtn"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span id="saveText">Save Category</span>
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 💫 JavaScript --}}
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImage = document.getElementById('removeImage');
    const form = document.getElementById('categoryForm');
    const saveBtn = document.getElementById('saveBtn');
    const saveText = document.getElementById('saveText');
    const loadingIcon = document.getElementById('loadingIcon');

    // Show preview
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                previewImg.src = event.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    removeImage.addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        previewImg.src = '';
    });

    // Loading effect on save
    form.addEventListener('submit', () => {
        saveText.textContent = "Saving...";
        loadingIcon.classList.remove('hidden');
        saveBtn.disabled = true;
        saveBtn.classList.add('opacity-70', 'cursor-not-allowed');
    });
</script>
@endsection
