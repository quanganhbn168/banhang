@extends('layouts.admin')
@section('title', 'Thêm Chứng chỉ')
@section('content_header', 'Thêm Chứng chỉ')

@section('content')
<form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            {{-- Tên chứng chỉ --}}
            <x-form.input name="name" label="Tên chứng chỉ/Bằng cấp" required />

            {{-- Đơn vị cấp --}}
            <x-form.input name="issued_by" label="Đơn vị cấp" />

            {{-- Ảnh của chứng chỉ --}}
            <x-form.image-input name="image" label="Ảnh chứng chỉ" required />

            <div class="row">
                <div class="col-md-6">
                    {{-- Ngày cấp --}}
                    <x-form.input type="date" name="issued_at" label="Ngày cấp" />
                </div>
                <div class="col-md-6">
                    {{-- Ngày hết hạn --}}
                    <x-form.input type="date" name="expired_at" label="Ngày hết hạn (nếu có)" />
                </div>
            </div>

            {{-- Mô tả ngắn --}}
            <x-form.textarea name="description" label="Mô tả" />
            
            {{-- Trạng thái hiển thị --}}
            <x-form.switch name="status" label="Hiển thị" :checked="true" />
        </div>
        <div class="card-footer">
            <button type="submit" name="save" class="btn btn-primary">Lưu</button>
            <button type="submit" name="save_new" class="btn btn-success">Lưu & Thêm mới</button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</form>
@endsection