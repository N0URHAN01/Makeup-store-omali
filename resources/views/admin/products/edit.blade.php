@extends('admin.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-pink-50 shadow-lg rounded-2xl p-8 border border-pink-100">
    <h2 class="text-3xl font-bold mb-8 text-pink-700 flex items-center gap-2">
        💄 Edit Product Details
    </h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- ✨ Basic Product Info --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-pink-100">
            <h3 class="text-lg font-semibold text-pink-600 mb-4">✨ Basic Product Info</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-pink-700 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border border-pink-200 rounded-lg focus:ring-pink-400 bg-pink-50 text-gray-800">
                </div>

                <div>
                    <label class="block font-medium text-pink-700 mb-2">Product Code (SKU)</label>
                    <input type="text" name="product_code" value="{{ $product->product_code }}"
                        readonly class="w-full bg-pink-100 border border-pink-200 rounded-lg text-gray-600 cursor-not-allowed">
                </div>
            </div>
        </div>

        {{-- 💰 Details & Inventory --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-pink-100">
            <h3 class="text-lg font-semibold text-pink-600 mb-4">💰 Details & Inventory</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-pink-700 mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border border-pink-200 rounded-lg focus:ring-pink-400 bg-pink-50 text-gray-800">
                </div>

                <div>
                    <label class="block font-medium text-pink-700 mb-2">Discount (%)</label>
                    <input type="number" name="discount_percentage" value="{{ old('discount_percentage', $product->discount_percentage) }}"
                        class="w-full border border-pink-200 rounded-lg focus:ring-pink-400 bg-pink-50 text-gray-800">
                </div>

                <div>
                    <label class="block font-medium text-pink-700 mb-2">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full border border-pink-200 rounded-lg focus:ring-pink-400 bg-pink-50 text-gray-800">
                </div>

                <div>
                    <label class="block font-medium text-pink-700 mb-2">Category</label>
                    <select name="category_id"
                        class="w-full border border-pink-200 rounded-lg focus:ring-pink-400 bg-pink-50 text-gray-800">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- 🖼️ Images & Description --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-pink-100">
            <h3 class="text-lg font-semibold text-pink-600 mb-4">🖼️ Description & Images</h3>

            {{-- Main Image --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-pink-700 mb-2">Replace Main Image</label>
                    @if ($product->image)
                        <div class="relative w-24 h-24 mb-3 rounded-lg overflow-hidden border border-pink-200 shadow-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            <button type="button" class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center delete-main-image-btn" data-id="{{ $product->id }}">×</button>
                        </div>
                    @endif
                    <input type="file" name="image" class="block w-full text-sm border border-pink-200 rounded-lg bg-pink-50">
                </div>

                {{-- Additional Images --}}
                <div>
                    <label class="block font-medium text-pink-700 mb-2">Upload Additional Images</label>
                    <input type="file" name="images[]" id="imageInput" multiple class="block w-full text-sm border border-pink-200 rounded-lg bg-pink-50">
                    <div id="previewImages" class="mt-4 flex flex-wrap gap-3"></div>
                </div>
            </div>

            {{-- Existing Additional Images --}}
            @if ($product->images->count())
                <h4 class="text-pink-600 font-semibold mt-6 mb-3">Existing Gallery</h4>
                <div class="flex flex-wrap gap-3">
                    @foreach ($product->images as $image)
                        <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-pink-200 shadow-sm">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                            <button type="button" class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded-full w-6 h-6 delete-image-btn" data-id="{{ $image->id }}">×</button>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <label class="block font-medium text-pink-700 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border border-pink-200 rounded-lg bg-pink-50 text-gray-800">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        {{-- 🎨 Product Variants --}}
        <div class="bg-white rounded-xl p-6 shadow-sm border border-pink-100">
            <h3 class="text-lg font-semibold text-pink-600 mb-4">🎨 Product Variants</h3>

            <div id="variantsContainer" class="space-y-4">
                @foreach ($product->variants as $index => $variant)
                    <div class="variant-row flex flex-wrap gap-4 items-end bg-pink-50 border border-pink-100 p-4 rounded-xl">
                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">

                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Color</label>
                            <input type="text" name="variants[{{ $index }}][color_name]" value="{{ $variant->color_name }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>

                        
                        
                        <div class="flex-1">
    <label class="block text-gray-800 mb-2 font-semibold">Color Code</label>
    <input type="color" name="variants[{{ $index }}][color_code]" value="{{ old('variants.'.$index.'.color_code', $variant->color_code) }}"
           class="w-full h-10 border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-pink-400">
</div>


                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Price Difference</label>
                            <input type="number" step="0.01" name="variants[{{ $index }}][price_difference]" value="{{ $variant->price_difference }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Stock</label>
                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-800 mb-2 font-semibold">Variant Image</label>
                            @if ($variant->image)
                               <div class="variant-image-wrapper relative w-24 h-24 rounded-lg overflow-hidden border border-pink-200 mb-2 shadow-sm">
    <img src="{{ asset('storage/' . $variant->image) }}" class="w-full h-full object-cover">
    <button type="button" class="absolute top-1 right-1 bg-red-600 text-white w-6 h-6 text-xs rounded-full delete-variant-image-btn" data-id="{{ $variant->id }}">×</button>
</div>

                            @endif
                            <input type="file" name="variants[{{ $index }}][image]" accept="image/*"
                                class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 p-2.5">
                        </div>
                         <button type="button" class="removeVariant bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-md mt-6">✕</button>
                    </div>
                @endforeach
            </div>
<button type="button" id="addVariantBtn" 
                    class="mt-4 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold px-5 py-2 rounded-xl shadow transition-all">
                    + Add Another Variant
                </button>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end space-x-3 pt-6">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700">
                💾 Update Product
            </button>
        </div>
    </form>
</div>

{{-- ✅ JS --}}
<script>
document.getElementById('imageInput').addEventListener('change', e => {
    const preview = document.getElementById('previewImages');
    preview.innerHTML = '';
    [...e.target.files].forEach(file => {
        const reader = new FileReader();
        reader.onload = ev => {
            const div = document.createElement('div');
            div.className = 'relative w-24 h-24 rounded-lg overflow-hidden border border-pink-200';
            div.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover">
            <button type="button" class="absolute top-1 right-1 bg-pink-600 text-white text-xs rounded-full w-6 h-6 hover:bg-pink-700">×</button>`;
            div.querySelector('button').onclick = () => div.remove();
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Delete gallery image
document.querySelectorAll('.delete-image-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        if (!confirm('Delete this image?')) return;
        fetch(`/admin/products/delete-image/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(r => r.json()).then(d => {
            if (d.success) btn.closest('.relative').remove();
        });
    });
});


// Delete variant images
document.querySelectorAll('.delete-variant-image-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        if (!confirm('Are you sure you want to delete this variant image?')) return;
        fetch(`/admin/products/delete-variant-image/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })

        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.closest('.variant-image-wrapper').remove(); 
            }
        });
    });
});

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
        const variantRow = e.target.closest('.variant-row');
        const variantIdInput = variantRow.querySelector('input[name*="[id]"]');
        const variantId = variantIdInput ? variantIdInput.value : null;

        if (variantId) {
            if (confirm('Are you sure you want to delete this variant?')) {
                fetch(`/admin/products/variant/${variantId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        variantRow.remove();
                    } else {
                        alert('Failed to delete variant.');
                    }
                })
                .catch(() => alert('Error deleting variant.'));
            }
        } else {
           
            if (document.querySelectorAll('.variant-row').length > 1) {
                variantRow.remove();
            }
        }
    }
});
</script>
@endsection
