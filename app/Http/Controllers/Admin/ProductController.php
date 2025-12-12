<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product with variants.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'product_code'        => 'required|string|max:100|unique:products,product_code',
            'description'         => 'nullable|string',
            'price'               => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock'               => 'required|integer|min:0',
            'category_id'         => 'nullable|exists:categories,id',
            'image'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.color_name'    => 'nullable|string|max:100',
            'variants.*.color_code'     => 'nullable|string|max:100',
            'variants.*.price_difference'    => 'nullable|numeric|min:0',
            'variants.*.stock'    => 'nullable|integer|min:0',
            'variants.*.image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Generate unique product code automatically
        $productCode = strtoupper(Str::random(8));

        // ✅ Save main image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // ✅ Create product
        $product = Product::create([
            'name' => $request->name,
            'product_code' => $productCode,
            'description' => $request->description,
            'price' => $request->price,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'image' => $imagePath,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        // ✅ Save additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/multiple', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // ✅ Save product variants (with optional image)
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['color_name']) || !empty($variant['color_code'])) {
                    $variantImage = null;
                    if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $variantImage = $variant['image']->store('products/variants', 'public');
                    }

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_name' => $variant['color_name'] ?? null,
                        'color_code' => $variant['color_code'] ?? null,
                        'price_difference' => $variant['price_difference'] ?? 0,
                        'stock' => $variant['stock'] ?? 0,
                        'image' => $variantImage,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified product with variants.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'images', 'variants'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load(['images', 'variants']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product and its variants.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'description'         => 'nullable|string',
            'price'               => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock'               => 'required|integer|min:0',
            'category_id'         => 'nullable|exists:categories,id',
            'image'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.*.id'       => 'nullable|integer|exists:product_variants,id',
            'variants.*.color_name'    => 'nullable|string|max:100',
            'variants.*.color_code'     => 'nullable|string|max:100',
            'variants.*.price_difference'    => 'nullable|numeric|min:0',
            'variants.*.stock'    => 'nullable|integer|min:0',
            'variants.*.image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Replace main image if uploaded
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        // ✅ Update product info
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        // ✅ Add new additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/multiple', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // ✅ Update or create variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $variant = isset($variantData['id']) ? ProductVariant::find($variantData['id']) : null;

                $variantImage = $variant?->image;

                // replace image if uploaded
                if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    if ($variant && $variant->image && Storage::disk('public')->exists($variant->image)) {
                        Storage::disk('public')->delete($variant->image);
                    }
                    $variantImage = $variantData['image']->store('products/variants', 'public');
                }

                if ($variant) {
                    $variant->update([
                        'color_name' => $variantData['color_name'] ?? null,
                        'color_code' => $variantData['color_code'] ?? null,
                        'price_difference' => $variantData['price_difference'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'image' => $variantImage,
                    ]);
                } else {
                    if (!empty($variantData['color_name']) || !empty($variantData['color_code'])) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_name' => $variantData['color_name'] ?? null,
                            'color_code' => $variantData['color_code'] ?? null,
                            'price_difference' => $variantData['price_difference'] ?? 0,
                            'stock' => $variantData['stock'] ?? 0,
                            'image' => $variantImage,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a product and all related images + variants.
     */
    public function destroy(Product $product)
    {
        // main image
        if (!empty($product->image) && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // additional images
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // variants + images
        foreach ($product->variants as $variant) {
            if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * ✅ Delete additional image (AJAX)
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        return response()->json(['success' => true]);
    }

    /**
     * ✅ Delete a variant (AJAX)
     */
    public function deleteVariant($id)
    {
        $variant = ProductVariant::findOrFail($id);
        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
            Storage::disk('public')->delete($variant->image);
        }
        $variant->delete();
        return response()->json(['success' => true]);
    }

    /**
     * ✅ Delete a variant image only (AJAX)
     */
    public function deleteVariantImage($id)
    {
        $variant = ProductVariant::findOrFail($id);
        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
            Storage::disk('public')->delete($variant->image);
        }
        $variant->update(['image' => null]);
        return response()->json(['success' => true]);
    }
}
