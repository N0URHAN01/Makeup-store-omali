@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container mx-auto p-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">🛍️ Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition-all">
            ← Back to Products
        </a>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 px-6 py-4 rounded-lg mb-6 border border-red-200 shadow-sm">
            <ul class="list-disc pl-6 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white shadow-xl rounded-2xl border border-pink-100 p-10 hover:shadow-2xl transition-all">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Product Name --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Product Name</label>
                    <input type="text" name="name" id="product_name" value="{{ old('name') }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                </div>

                {{-- Product Code --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Product Code</label>
                    <input type="text" name="product_code" id="product_code" readonly
                           class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5 text-gray-600">
                    <p class="text-xs text-gray-500 mt-1">Generated automatically.</p>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Category</label>
                    <select name="category_id" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Price (EGP)</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                </div>

                {{-- Discount --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Discount (%)</label>
                    <input type="number" name="discount_percentage" step="0.01" value="{{ old('discount_percentage', 0) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                </div>

                {{-- Stock --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Stock Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-800 mb-2 font-semibold">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-3">{{ old('description') }}</textarea>
                </div>

                {{-- Main Image --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Main Image</label>
                    <input type="file" name="image" id="mainImage" accept="image/*"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                    <div id="mainImagePreview" class="mt-3 flex flex-wrap gap-3"></div>
                </div>

                {{-- Additional Images --}}
                <div>
                    <label class="block text-gray-800 mb-2 font-semibold">Additional Images</label>
                    <input type="file" name="images[]" id="extraImages" accept="image/*" multiple
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                    <p class="text-xs text-gray-500 mt-1">Select multiple images if needed.</p>
                    <div id="extraImagesPreview" class="mt-3 flex flex-wrap gap-3"></div>
                </div>
            </div>

            {{-- Variants Section --}}
            <div class="border-t border-pink-200 pt-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">🎨 Product Variants</h2>
                <div id="variantsContainer" class="space-y-4">
                    <div class="variant-row flex flex-wrap gap-4 items-end bg-pink-50 border border-pink-100 p-4 rounded-xl">
                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Color Name</label>
                            <input type="text" name="variants[0][color_name]" placeholder="e.g., Red"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Color Code</label>
                            <input type="color" name="variants[0][color_code]"
                                   class="w-full h-10 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Stock</label>
                            <input type="number" name="variants[0][stock]" value="0"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Price Difference (EGP)</label>
                            <input type="number" step="0.01" name="variants[0][price_difference]" placeholder="e.g., +10"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Variant Image</label>
                            <input type="file" name="variants[0][image]" accept="image/*"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>
                        <button type="button" class="removeVariant bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-md mt-6">✕</button>
                    </div>
                </div>

                <button type="button" id="addVariantBtn" 
                    class="mt-4 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold px-5 py-2 rounded-xl shadow transition-all">
                    + Add Another Variant
                </button>
            </div>

            {{-- Submit --}}
            <div class="text-right">
                <button type="submit" 
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    💾 Save Product
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JS --}}
<script>
    // Generate random product code
    function generateRandomCode() {
        return 'PRD-' + Math.random().toString(36).substring(2, 10).toUpperCase();
    }

    document.getElementById('product_name').addEventListener('input', function () {
        const codeInput = document.getElementById('product_code');
        if (!codeInput.value) codeInput.value = generateRandomCode();
    });

    // Image preview with remove button
    function previewImages(input, previewContainerId) {
        const container = document.getElementById(previewContainerId);
        container.innerHTML = '';
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = "relative w-24 h-24 rounded-lg overflow-hidden shadow-md border border-gray-200";
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = "object-cover w-full h-full";
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerHTML = '✕';
                btn.className = "absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow-md";
                btn.onclick = () => wrapper.remove();
                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    document.getElementById('mainImage').addEventListener('change', e => previewImages(e.target, 'mainImagePreview'));
    document.getElementById('extraImages').addEventListener('change', e => previewImages(e.target, 'extraImagesPreview'));

    // Add/Remove Variants
    let variantIndex = 1;
    document.getElementById('addVariantBtn').addEventListener('click', function () {
        const container = document.getElementById('variantsContainer');
        const newRow = container.firstElementChild.cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.name = input.name.replace(/\d+/, variantIndex);
        });
        container.appendChild(newRow);
        variantIndex++;
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('removeVariant')) {
            if (document.querySelectorAll('.variant-row').length > 1) {
                e.target.closest('.variant-row').remove();
            }
        }
    });
</script>
@endsection
