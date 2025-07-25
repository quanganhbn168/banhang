@extends('layouts.admin')
@section('title','Dashboard')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <style>
        body { padding: 1rem; }
        #calendar { max-width: 1100px; margin: 20px auto; }
        .fc-event { cursor: pointer; } /* Thêm con trỏ cho sự kiện */
    </style>
@endpush
@section('content')
    <h1 class="mb-4 text-center">Lịch Booking</h1>

    <div class="row mb-3 justify-content-center">
        <div class="col-md-3">
            <label for="filter_status" class="form-label">Lọc theo trạng thái:</label>
            <select id="filter_status" class="form-select">
                <option value="all">Tất cả</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="pending">Đang chờ</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>
    </div>

    <div id='calendar'></div>

    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Thêm/Sửa Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm">
                        <input type="hidden" id="bookingId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Thời gian bắt đầu</label>
                            <input type="datetime-local" class="form-control" id="startTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">Thời gian kết thúc</label>
                            <input type="datetime-local" class="form-control" id="endTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select id="status" class="form-select">
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="pending">Đang chờ</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteBookingBtn" style="display:none;">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="bookingForm">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- PHẦN JAVASCRIPT --}}
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const bookingModalEl = document.getElementById('bookingModal');
            const bookingModal = new bootstrap.Modal(bookingModalEl);
            const bookingForm = document.getElementById('bookingForm');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'vi',
                buttonText: { today: 'Hôm nay', month: 'Tháng', week: 'Tuần', day: 'Ngày', list: 'Danh sách' },
                editable: true,
                selectable: true,
                
                // Nguồn sự kiện (lấy từ backend, có kèm filter)
                events: function(fetchInfo, successCallback, failureCallback) {
                    const status = document.getElementById('filter_status').value;
                    fetch(`{{ route('admin.bookings.events') }}?status=${status}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },

                // === CÁC HÀNH ĐỘNG ===

                // 1. CLICK VÀO NGÀY TRỐNG ĐỂ TẠO MỚI
                dateClick: function(info) {
                    bookingForm.reset();
                    document.getElementById('bookingId').value = '';
                    document.getElementById('bookingModalLabel').innerText = 'Thêm Booking mới';
                    document.getElementById('deleteBookingBtn').style.display = 'none';

                    // Set ngày/giờ mặc định
                    document.getElementById('startTime').value = info.dateStr + 'T09:00';
                    document.getElementById('endTime').value = info.dateStr + 'T10:00';

                    bookingModal.show();
                },

                // 2. CLICK VÀO SỰ KIỆN ĐỂ SỬA
                eventClick: function(info) {
                    document.getElementById('bookingModalLabel').innerText = 'Chỉnh sửa Booking';
                    document.getElementById('deleteBookingBtn').style.display = 'block';

                    // Điền dữ liệu vào form
                    document.getElementById('bookingId').value = info.event.id;
                    document.getElementById('title').value = info.event.title;
                    document.getElementById('status').value = info.event.extendedProps.status;
                    
                    // Format lại ngày giờ cho input datetime-local (YYYY-MM-DDTHH:mm)
                    const formatDateTimeLocal = (date) => {
                        const dt = new Date(date);
                        dt.setMinutes(dt.getMinutes() - dt.getTimezoneOffset());
                        return dt.toISOString().slice(0, 16);
                    };

                    document.getElementById('startTime').value = formatDateTimeLocal(info.event.start);
                    document.getElementById('endTime').value = info.event.end ? formatDateTimeLocal(info.event.end) : formatDateTimeLocal(info.event.start);

                    bookingModal.show();
                },
                
                // 3. KÉO THẢ SỰ KIỆN ĐỂ CẬP NHẬT
                eventDrop: function(info) {
                    updateBookingTime(info.event);
                },

                // 4. THAY ĐỔI KÍCH THƯỚC SỰ KIỆN
                eventResize: function(info) {
                    updateBookingTime(info.event);
                }
            });

            calendar.render();

            // XỬ LÝ FORM SUBMIT (TẠO MỚI HOẶC CẬP NHẬT)
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('bookingId').value;
                const url = id ? `{{ url('admin/bookings') }}/${id}` : '{{ route('admin.bookings.store') }}';
                const method = id ? 'PATCH' : 'POST';

                const data = {
                    title: document.getElementById('title').value,
                    start_time: document.getElementById('startTime').value,
                    end_time: document.getElementById('endTime').value,
                    status: document.getElementById('status').value,
                };

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if(data.errors) {
                       alert('Có lỗi xảy ra: ' + Object.values(data.errors).join('\n'));
                       return;
                    }
                    bookingModal.hide();
                    calendar.refetchEvents(); // Tải lại sự kiện
                }).catch(error => console.error('Error:', error));
            });
            
            // XỬ LÝ NÚT XÓA
            document.getElementById('deleteBookingBtn').addEventListener('click', function() {
                const id = document.getElementById('bookingId').value;
                if (!id) return;

                if (confirm('Bạn có chắc chắn muốn xóa booking này không?')) {
                    fetch(`{{ url('admin/bookings') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        bookingModal.hide();
                        calendar.refetchEvents();
                    }).catch(error => console.error('Error:', error));
                }
            });

            // XỬ LÝ BỘ LỌC
            document.getElementById('filter_status').addEventListener('change', function() {
                calendar.refetchEvents(); // Tải lại sự kiện khi thay đổi bộ lọc
            });

            // HÀM HELPER ĐỂ CẬP NHẬT THỜI GIAN KHI KÉO THẢ
            function updateBookingTime(event) {
                const data = {
                    start_time: event.start.toISOString(),
                    end_time: event.end ? event.end.toISOString() : event.start.toISOString(),
                };

                fetch(`{{ url('admin/bookings') }}/${event.id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                     if(data.errors) {
                       alert('Cập nhật thất bại!');
                       info.revert();
                    } else {
                       console.log('Cập nhật thời gian thành công!');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    info.revert(); // Trả sự kiện về vị trí cũ nếu có lỗi
                });
            }
        });
    </script>
@endpush