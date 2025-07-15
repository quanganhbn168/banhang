<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index()
    {
        $products = $this->productService->getAll();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->productService->getParentOptions();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->productService->create($request);

        $route = $request->has('save_new')
            ? route('admin.products.create')
            : route('admin.products.index');

        return redirect($route)->with('success', 'Thêm sản phẩm thành công.');
    }

    public function edit(Product $product)
    {
        $categories = $this->productService->getParentOptions();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->productService->update($request, $product);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return redirect()->route('admin.products.index')->with('success', 'Xoá sản phẩm thành công.');
    }
}
