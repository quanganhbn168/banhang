<?php

namespace App\Services;

use App\Models\Certificate;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Str;

class CertificateService
{
    use UploadImageTrait;

    /**
     * Lấy tất cả chứng chỉ, có phân trang.
     */
    public function getAll()
    {
        // Sử dụng paginate để phân trang, 10 mục mỗi trang
        return Certificate::latest()->paginate(10);
    }

    /**
     * Tạo mới một chứng chỉ.
     *
     * @param array $data Dữ liệu đã được validate từ controller.
     * @return Certificate
     */
    public function store(array $data): Certificate
    {
        // Xử lý upload ảnh nếu có
        if (isset($data['image'])) {
            // Giả sử trait có phương thức uploadImage(file, 'folder_name')
            $data['image'] = $this->uploadImage($data['image'], 'certificates');
        }

        // Tự động tạo slug từ name
        $data['slug'] = Str::slug($data['name']);

        // Tạo mới record
        return Certificate::create($data);
    }

    /**
     * Cập nhật một chứng chỉ.
     *
     * @param array $data Dữ liệu đã được validate từ controller.
     * @param Certificate $certificate Model chứng chỉ cần cập nhật.
     * @return Certificate
     */
    public function update(array $data, Certificate $certificate): Certificate
    {
        // Xử lý upload ảnh mới nếu có
        if (isset($data['image'])) {
            // Upload ảnh mới và xóa ảnh cũ
            $data['image'] = $this->uploadImage($data['image'], 'certificates');
            $this->deleteImage($certificate->image);
        }

        // Cập nhật slug nếu tên thay đổi
        $data['slug'] = Str::slug($data['name']);

        // Cập nhật record
        $certificate->update($data);
        return $certificate;
    }

    /**
     * Xóa một chứng chỉ.
     *
     * @param Certificate $certificate Model chứng chỉ cần xóa.
     * @return void
     */
    public function delete(Certificate $certificate): void
    {
        // Xóa ảnh liên quan trước
        $this->deleteImage($certificate->image);
        // Xóa record khỏi database
        $certificate->delete();
    }
}