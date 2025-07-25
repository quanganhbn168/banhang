@extends('layouts.admin')
@section('title', 'Thêm Phản hồi')
@section('content_header', 'Thêm Phản hồi')

@section('content')
<form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <x-form.input name="name" label="Tên khách hàng" required />
            <x-form.input name="position" label="Chức vụ/Vị trí" placeholder="VD: Giám đốc công ty ABC, Khách hàng..." />
            <x-form.image-input name="image" label="Ảnh đại diện" />
            <x-form.textarea name="content" label="Nội dung phản hồi" required />
            <x-form.switch name="status" label="Hiển thị" :checked="true" />
        </div>
        <div class="card-footer">
            <button type="submit" name="save" class="btn btn-primary">Lưu</button>
            <button type="submit" name="save_new" class="btn btn-success">Lưu & Thêm mới</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</form>
@endsection