@extends('layouts.admin')
@section('title', 'Danh sách Phản hồi')
@section('content_header', 'Danh sách Phản hồi')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th style="width: 100px">Ảnh</th>
                    <th>Tên khách hàng</th>
                    <th>Chức vụ/Vị trí</th>
                    <th style="width: 100px">Trạng thái</th>
                    <th style="width: 120px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->id }}</td>
                        <td>
                            @if($testimonial->image_url)
                                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="img-fluid" style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ $testimonial->name }}</td>
                        <td>{{ $testimonial->position }}</td>
                        <td>
                            @if ($testimonial->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection