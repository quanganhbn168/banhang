<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\UploadImageTrait;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'map'            => 'nullable|string',
            'schema_script'  => 'nullable|string',
            'head_script'    => 'nullable|string',
            'body_script'    => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'favicon'        => 'nullable|image|mimes:ico,png,jpg,jpeg|max:512',
        ]);

        // Logo upload
        if ($request->hasFile('logo')) {
            if ($setting && $setting->logo) {
                $this->deleteImage($setting->logo);
            }

            $data['logo'] = $this->uploadImage(
                $request->file('logo'),
                folder: 'settings',        // folder
                resizeWidth: 512,          // optional: resize nhỏ cho logo
                convertToWebp: true,
                watermarkPath: ''          // watermark = false
            );
        }

        // Favicon upload
        // Favicon upload
        if ($request->hasFile('favicon')) {
            if ($setting && $setting->favicon) {
                $this->deleteImage($setting->favicon);   // xoá bản ghi DB cũ
            }

            $data['favicon'] = $this->generateFavicon($request->file('favicon'));
        }


        $setting ? $setting->update($data) : Setting::create($data);

        return redirect()->route('admin.settings.index')->with('success', 'Cập nhật cài đặt thành công.');
    }

    protected function generateFavicon(UploadedFile $file): string
    {
        $folder = public_path('favicon');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // danh sách size kèm tên file
        $sizes = [
            16  => 'favicon-16x16.png',
            32  => 'favicon-32x32.png',
            180 => 'apple-touch-icon.png',
            192 => 'icon-192.png',
            512 => 'icon-512.png',
        ];

        // xoá file cũ cùng tên (nếu có) để tránh cache CDN/local
        foreach ($sizes as $filename) {
            $path = $folder . '/' . $filename;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        if (File::exists($folder . '/favicon.png')) {
            File::delete($folder . '/favicon.png');
        }

        // tạo từng size PNG
        foreach ($sizes as $size => $filename) {
            Image::make($file->getRealPath())
                ->fit($size, $size)        // giữ tỷ lệ, crop trung tâm
                ->encode('png', 90)
                ->save($folder . '/' . $filename);
        }

        // thêm favicon.ico (32×32)
        Image::make($file->getRealPath())
            ->fit(32, 32)
            ->encode('png')
            ->save($folder . '/favicon.png');

        // trả về path 32×32 để lưu DB
        return 'favicon/favicon-32x32.png';
    }
}
