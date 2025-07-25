{{-- resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Basic --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title & SEO --}}
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description', 'Nha khoa Bani')">
    <meta name="keywords" content="@yield('meta_keywords', 'Nha khoa Bắc Ninh, Các từ khoá khác')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type','website')" />
    <meta property="og:title"       content="@yield('title', config('app.name')) " />
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:url"         content="{{ url()->current() }}" />
    <meta property="og:site_name"   content="{{ $setting->name }}" />
    <meta property="og:image"       content="@yield('meta_image', asset('images/setting/THTMEDIA.png'))" />

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image" />
    <meta name="twitter:title"       content="@yield('title', config('app.name'))" />
    <meta name="twitter:description" content="@yield('meta_description')" />
    <meta name="twitter:image"       content="@yield('meta_image', asset('images/setting/THTMEDIA.png'))" />
    {{-- Fonts, Favicons --}}
    <link rel="icon" href="{{ asset($setting->favicon) }}" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($setting->favicon) }}" />
    {{-- CSS & JS --}}
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/slide.css') }}?v={{ filemtime(public_path('css/slide.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}?v={{ filemtime(public_path('css/global.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}?v={{ filemtime(public_path('css/responsive.css')) }}">
    @stack('css')
</head>

<body>
    
    @include('partials.frontend.header')
    @yield('content')
    @include('partials.frontend.footer')
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Thông tin Đặt lịch hẹn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            {{-- Form sẽ submit tới một route chúng ta sẽ tạo ở dưới --}}
            <form action="{{ route('bookings.public.store') }}" method="POST" id="bookingForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customerName">Họ và tên</label>
                        <input type="text" class="form-control" id="customerName" name="customer_name" placeholder="Nguyễn Văn A" required>
                    </div>

                    <div class="form-group">
                        <label for="customerPhone">Số điện thoại</label>
                        <input type="tel" class="form-control" id="customerPhone" name="customer_phone" placeholder="09xxxxxxxx" required>
                    </div>

                    <div class="form-group">
                        <label for="serviceSelect">Chọn dịch vụ</label>
                        <select class="form-control" id="serviceSelect" name="service_id" required>
                            <option value="" disabled selected>-- Vui lòng chọn dịch vụ --</option>
                            @php
                            $dattruoc = DB::table('service_categories')->where("status",1)->get();
                            @endphp
                            @if(isset($dattruoc))
                                @foreach ($dattruoc as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bookingStartTime">Chọn ngày giờ mong muốn</label>
                        <input type="datetime-local" class="form-control" id="bookingStartTime" name="start_time" required>
                    </div>
                    {{-- Trường ẩn này sẽ chứa title được gộp lại bằng JavaScript --}}
                    <input type="hidden" name="title" id="bookingTitle">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Gửi thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="{{asset('/js/jquery-3.7.1.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/bootstrap/popper.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/bootstrap/js/bootstrap.min.js')}}?{{time()}}"></script>
    <script src="{{asset('/vendor/swiper/swiper-bundle.min.js')}}?{{time()}}"></script>
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: @json(session('success')),
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: @json(session('error')),
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".gotop").addEventListener("click", function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const bookingForm = document.getElementById('bookingForm');
    const customerNameInput = document.getElementById('customerName');
    const customerPhoneInput = document.getElementById('customerPhone');
    const serviceSelect = document.getElementById('serviceSelect');
    const bookingTitleInput = document.getElementById('bookingTitle');

    function updateBookingTitle() {
        const name = customerNameInput.value.trim();
        const phone = customerPhoneInput.value.trim();
        const selectedServiceOption = serviceSelect.options[serviceSelect.selectedIndex];
        const serviceText = selectedServiceOption.value ? selectedServiceOption.text : '';

        if (name && phone && serviceText) {
            // Gộp thông tin thành một chuỗi title duy nhất
            bookingTitleInput.value = `Lịch hẹn: ${name} - ${phone} - ${serviceText}`;
        } else {
            bookingTitleInput.value = '';
        }
    }

    // Lắng nghe sự kiện trên các trường input để cập nhật title
    if (bookingForm) {
        customerNameInput.addEventListener('input', updateBookingTitle);
        customerPhoneInput.addEventListener('input', updateBookingTitle);
        serviceSelect.addEventListener('change', updateBookingTitle);
    }

    // --- PHẦN BỔ SUNG: Chặn chọn ngày trong quá khứ ---
    const startTimeInput = document.getElementById('bookingStartTime');
    if (startTimeInput) {
        // Lấy thời gian hiện tại
        const now = new Date();
        // Điều chỉnh múi giờ cho đúng với định dạng của input (YYYY-MM-DDTHH:mm)
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        // Set thuộc tính 'min' cho input
        startTimeInput.min = now.toISOString().slice(0, 16);
    }
});
</script>
    @stack('js')
</body>
</html>
