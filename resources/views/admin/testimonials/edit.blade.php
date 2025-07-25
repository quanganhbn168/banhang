@extends('layouts.admin')
@section('title', 'Cập nhật Phản hồi')
@section('content_header', 'Cập nhật Phản hồi')

@section('content')
<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <x-form.input name="name" label="Tên khách hàng" :value="$testimonial->name" required />
            <x-form.input name="position" label="Chức vụ/Vị trí" :value="$testimonial->position" placeholder="VD: Giám đốc công ty ABC, Khách hàng..." />
            <x-form.image-input name="image" label="Ảnh đại diện" :value="$testimonial->image" />
            <x-form.textarea name="content" label="Nội dung phản hồi" :value="$testimonial->content" required />
            <x-form.switch name="status" label="Hiển thị" :checked="$testimonial->status" />
        </div>
        <div class="card-footer">
            <button type="submit" name="action" value="update" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</form>
@endsection