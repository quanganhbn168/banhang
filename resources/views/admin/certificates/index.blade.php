@extends('layouts.admin')
@section('title', 'Danh sách Chứng chỉ')
@section('content_header', 'Danh sách Chứng chỉ')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th style="width: 100px">Ảnh</th>
                    <th>Tên chứng chỉ</th>
                    <th>Đơn vị cấp</th>
                    <th>Ngày cấp</th>
                    <th style="width: 100px">Trạng thái</th>
                    <th style="width: 120px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($certificates as $certificate)
                    <tr>
                        <td>{{ $certificate->id }}</td>
                        <td>
                            <img src="{{ $certificate->image_url }}" alt="{{ $certificate->name }}" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td>{{ $certificate->name }}</td>
                        <td>{{ $certificate->issued_by }}</td>
                        <td>{{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            @if ($certificate->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $certificates->links() }}
    </div>
</div>
@endsection