<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    protected $certificateService;

    // Sử dụng Dependency Injection để inject CertificateService vào controller
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Hiển thị danh sách các chứng chỉ.
     */
    public function index()
    {
        // Gọi service để lấy dữ liệu
        $certificates = $this->certificateService->getAll();
        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Hiển thị form để tạo mới chứng chỉ.
     */
    public function create()
    {
        return view('admin.certificates.create');
    }

    /**
     * Lưu một chứng chỉ mới vào database.
     */
    public function store(Request $request)
    {
        // 1. Controller chỉ validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificates,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'issued_by' => 'nullable|string|max:255',
            'issued_at' => 'nullable|date',
            'expired_at' => 'nullable|date|after_or_equal:issued_at',
            'description' => 'nullable|string',
        ]);
        
        // Thêm trường status vào dữ liệu đã validate
        $validated['status'] = $request->has('status');

        try {
            // 2. Gửi dữ liệu đã validate cho service xử lý
            $this->certificateService->store($validated);

            // Xử lý các nút lưu
            if ($request->input('save_new')) {
                return redirect()->route('admin.certificates.create')->with('success', 'Thêm chứng chỉ thành công!');
            }

            return redirect()->route('admin.certificates.index')->with('success', 'Thêm chứng chỉ thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm chứng chỉ: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')->withInput();
        }
    }

    /**
     * Hiển thị form để chỉnh sửa một chứng chỉ.
     */
    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    /**
     * Cập nhật một chứng chỉ trong database.
     */
    public function update(Request $request, Certificate $certificate)
    {
        // 1. Controller validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certificates,name,' . $certificate->id,
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'issued_by' => 'nullable|string|max:255',
            'issued_at' => 'nullable|date',
            'expired_at' => 'nullable|date|after_or_equal:issued_at',
            'description' => 'nullable|string',
        ]);

        $validated['status'] = $request->has('status');
        
        // Gán file vào mảng validated nếu có để service xử lý
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        try {
            // 2. Gửi dữ liệu đã validate và model cho service xử lý
            $this->certificateService->update($validated, $certificate);

            return redirect()->route('admin.certificates.index')->with('success', 'Cập nhật chứng chỉ thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật chứng chỉ: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')->withInput();
        }
    }

    /**
     * Xóa một chứng chỉ khỏi database.
     */
    public function destroy(Certificate $certificate)
    {
        try {
            // Gọi service để xóa
            $this->certificateService->delete($certificate);
            return redirect()->route('admin.certificates.index')->with('success', 'Xóa chứng chỉ thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa chứng chỉ: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}