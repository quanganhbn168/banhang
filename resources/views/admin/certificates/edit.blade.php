@extends('layouts.admin')
@section('title', 'Cập nhật Chứng chỉ')
@section('content_header', 'Cập nhật Chứng chỉ')

@section('content')
<form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            {{-- Tên chứng chỉ --}}
            <x-form.input name="name" label="Tên chứng chỉ/Bằng cấp" :value="$certificate->name" required />

            {{-- Đơn vị cấp --}}
            <x-form.input name="issued_by" label="Đơn vị cấp" :value="$certificate->issued_by" />

            {{-- Ảnh của chứng chỉ --}}
            <x-form.image-input name="image" label="Ảnh chứng chỉ" :value="$certificate->image" />

            <div class="row">
                <div class="col-md-6">
                    {{-- Ngày cấp --}}
                    <x-form.input type="date" name="issued_at" label="Ngày cấp" :value="$certificate->issued_at" />
                </div>
                <div class="col-md-6">
                    {{-- Ngày hết hạn --}}
                    <x-form.input type="date" name="expired_at" label="Ngày hết hạn (nếu có)" :value="$certificate->expired_at" />
                </div>
            </div>
            
            {{-- Mô tả ngắn --}}
            <x-form.textarea name="description" label="Mô tả" :value="$certificate->description" />

            {{-- Trạng thái hiển thị --}}
            <x-form.switch name="status" label="Hiển thị" :checked="$certificate->status" />
        </div>
        <div class="card-footer">
            <button type="submit" name="action" value="update" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</form>
@endsection