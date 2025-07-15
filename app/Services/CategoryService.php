<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryService
{
    use UploadImageTrait;

    public function create(Request $request): Category
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:categories,slug',
            'image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'parent_id' => 'nullable|integer|min:0',
            'status'  => 'nullable|boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['parent_id'] = (int) ($data['parent_id'] ?? 0);
        $data['image'] = $this->uploadImage($request->file('image'), 'uploads/categories', 800, 800, true);
        
        if ($request->hasFile('banner')) {
            $data['banner'] = $this->uploadImage($request->file('banner'), 'uploads/categories', 1920, 600, true);
        }

        return Category::create($data);
    }

    public function update(Request $request, Category $category): Category
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'parent_id' => 'nullable|integer|min:0',
            'status'  => 'nullable|boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['parent_id'] = (int) ($data['parent_id'] ?? 0);

        if ($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'uploads/categories', 800, 800, true);
        }

        if ($request->hasFile('banner')) {
            $this->deleteImage($category->banner);
            $data['banner'] = $this->uploadImage($request->file('banner'), 'uploads/categories', 1920, 600, true);
        }

        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        $this->deleteImage($category->image);
        $this->deleteImage($category->banner);
        $category->delete();
    }
}
