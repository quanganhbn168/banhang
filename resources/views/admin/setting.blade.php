@extends('layouts.admin')
@section('title','Cài đặt chung')
@section('content_header','Cài đặt chung')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cài đặt chung</h3>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <x-form.input name="name" label="Tên Công ty" :value="$setting->name ?? ''" />
            <x-form.input name="email" label="Email" :value="$setting->email ?? ''" />
            <x-form.input name="phone" label="Số điện thoại" :value="$setting->phone ?? ''" />
            <x-form.input name="address" label="Địa chỉ" :value="$setting->address ?? ''" />
            <x-form.ckeditor name="map" label="Iframe Google Map" :value="$setting->map ?? ''" />
            <x-form.image-input
                name="logo"
                label="Logo"
                :value="$setting->logo ?? ''"
            />
            <x-form.image-input
                name="favicon"
                label="Favicon"
                :value="$setting->favicon ?? ''"
            />
            {{-- CKEditor for script fields --}}
			<x-form.ckeditor name="schema_script" label="Schema JSON-LD" :value="$setting->schema_script ?? ''" />
            <x-form.ckeditor name="head_script" label="Code trước </head>" :value="$setting->head_script ?? ''" />
            <x-form.ckeditor name="body_script" label="Code trước </body>" :value="$setting->body_script ?? ''" />
	   </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
        </div>
    </form>
</div>
@endsection
