<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index()
    {
        $testimonials = $this->testimonialService->getAll();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'content' => 'required|string',
        ]);

        $validated['status'] = $request->has('status');
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        try {
            $this->testimonialService->store($validated);

            if ($request->input('save_new')) {
                return redirect()->route('admin.testimonials.create')->with('success', 'Thêm phản hồi thành công!');
            }

            return redirect()->route('admin.testimonials.index')->with('success', 'Thêm phản hồi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm phản hồi: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')->withInput();
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'content' => 'required|string',
        ]);

        $validated['status'] = $request->has('status');
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        try {
            $this->testimonialService->update($validated, $testimonial);
            return redirect()->route('admin.testimonials.index')->with('success', 'Cập nhật phản hồi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật phản hồi: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')->withInput();
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            $this->testimonialService->delete($testimonial);
            return redirect()->route('admin.testimonials.index')->with('success', 'Xóa phản hồi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa phản hồi: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}