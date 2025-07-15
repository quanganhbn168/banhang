<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UploadImageTrait;
use App\Handlers\ImageGalleryHandler;

class ProductService
{
    use UploadImageTrait;

    public function __construct(protected ImageGalleryHandler $imageGallery) {}

    public function getAll()
    {
        return Product::with('category')->latest()->paginate(20);
    }

    public function getParentOptions()
    {
        return \App\Models\Category::pluck('name', 'id')->toArray();
    }

    public function create(Request $request): Product
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:products,slug',
            'price'           => 'nullable|numeric',
            'price_discount'  => 'nullable|numeric',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status'          => 'boolean',
            'is_home'         => 'boolean',
            'gallery'         => 'nullable|array',
            'gallery.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] ??= Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'uploads/products', 800, true);
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->uploadImage($request->file('banner'), 'uploads/products', 1920, true);
        }

        $product = Product::create($data);

        $this->imageGallery->sync($product, $request, 'gallery', 'uploads/products/gallery');

        return $product;
    }

    public function update(Request $request, Product $product): Product
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'price'           => 'nullable|numeric',
            'price_discount'  => 'nullable|numeric',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status'          => 'boolean',
            'is_home'         => 'boolean',
            'gallery'         => 'nullable|array',
            'gallery.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] ??= Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($product->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'uploads/products', 800, true);
        }

        if ($request->hasFile('banner')) {
            $this->deleteOldImage($product->banner);
            $data['banner'] = $this->uploadImage($request->file('banner'), 'uploads/products', 1920, true);
        }

        $product->update($data);

        $this->imageGallery->sync($product, $request, 'gallery', 'uploads/products/gallery');

        return $product;
    }

    public function delete(Product $product): bool
    {
        $this->deleteOldImage($product->image);
        $this->deleteOldImage($product->banner);
        return $product->delete();
    }
}
