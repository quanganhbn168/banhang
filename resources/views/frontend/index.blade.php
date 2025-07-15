@extends('layouts.master')
@section('title','Trang chủ')
@push('css')
<link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}?{{time()}}">
<style>
    .doctor-img-wrapper {
    position: relative;
    overflow: hidden;
}
.view-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 84, 84, 0.8);
    border: none;
    color: #fff;
    border-radius: 50%;
    padding: 10px 14px;
    font-size: 20px;
    z-index: 10;
    transition: 0.3s;
}
.view-btn:hover {
    background-color: rgba(0, 84, 84, 1);
}
.doctor-info {
    background-color: #00796b;
    color: #fff;
}
.eye-icon {
    font-size: 18px;
    color: #ffffff;
}

    .sliderAfter-tab .nav-link {
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 6px;
    color: #333;
}
.sliderAfter-tab .nav-link.active {
    background-color: var(--primary-color, #1e88e5);
    color: #fff;
}
div#slider-tabContent {
    text-align: center;
}
.posts-wrapper{
    background-color: #ffffff;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 20px 10px;
}
</style>
@endpush
@section('content')
@include('partials.frontend.slide')
<section class="section services">
    <h2 class="section-title">Dịch vụ chăm sóc răng miệng cáo cấp tại Nha Khoa Bani</h2>
    <div class="container">
        <div class="row">
            @foreach($serviceCategory as $key => $service)
            <div class="col-6 col-md-3 col-sm-6 mb-3">
                <div class="services-item">
                    <a href="{{route('slug.resolve', $service->slug)}}" class="item-link">
                        <div class="item-image">
                            <img src="{{asset($service->image)}}" alt="{{$service->name}}" width="253" height="253">
                        </div>
                        <p class="item-name">{{$service->name}}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="section-seemore text-center mt-4">
            <a href="#" class="btn btn-primary">
                <span>
                    Xem thêm dịch vụ
                    <i class="fa-solid fa-angles-right"></i>
                </span>
            </a>
        </div>
    </div>          
</section>
<section class="section about">
    <div class="container">
        @foreach($intros as $key => $intro)
        {{-- Phần giới thiệu chính --}}
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="about-image">
                    <img src="{{ asset($intro->image) }}" alt="{{ $setting->name }}" width="800" height="800">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="about-description">
                    <h2 class="about-name">{{$intro->title}}</h2>
                    <div class="about-des">
                        {!! $intro->description !!}
                    </div>
                    <div class="text-center about-more">
                        <a type="button" class="btn btn-primary" href="{{ route('intro.show') }}">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>



<section class="section team">
    <h2 class="section-title">Đội ngũ bác sĩ</h2>
    <div class="row">
        @foreach($teams as $team)
        <div class="col-6 col-md-4 col-sm-6 mb-4">
            <div class="doctor-card text-center">
                <div class="doctor-img-wrapper position-relative">
                    <img src="{{ asset($team->image) }}" alt="{{ $team->name }}" class="img-fluid w-100">
                    <button class="view-btn" data-toggle="modal" data-target="#doctorModal{{ $team->id }}">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="doctor-info bg-primary text-white py-3">
                    <h5 class="mb-1 text-uppercase">{{ $team->name }}</h5>
                    <small>{{ $team->position }}</small>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="doctorModal{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="doctorModalLabel{{ $team->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content p-4">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="doctorModalLabel{{ $team->id }}">Thông tin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-bold text-uppercase mb-1">Bác sĩ</p>
                        <h5 class="text-uppercase">{{ $team->name }}</h5>
                        <p><strong>Chức vụ:</strong> {{ $team->position }}</p>
                        <p><strong>Trình độ:</strong> {{ $team->level }}</p>
                        <p><strong>Kinh nghiệm:</strong> {{ $team->experience }} năm</p>
                        <p>{!! nl2br(e($team->bio)) !!}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>



<section class="section testimonial position-relative text-white">
    <div class="container">
    <h2 class="section-title text-center mb-5">Cảm nhận khách hàng</h2>

    <div class="swiper testimonial-swiper">
        <div class="swiper-wrapper">
            @foreach([
                ['name' => 'Nguyễn Minh Anh', 'avatar' => 'images/avatar/avatar1.jpg', 'rating' => 5, 'comment' => 'Dịch vụ tuyệt vời! Bác sĩ tận tâm, tôi hoàn toàn yên tâm khi điều trị tại đây.'],
                ['name' => 'Trần Hữu Đức', 'avatar' => 'images/avatar/avatar2.jpg', 'rating' => 4, 'comment' => 'Không gian sạch sẽ, hiện đại. Nhân viên thân thiện và chuyên nghiệp.'],
                ['name' => 'Phạm Thị Hằng', 'avatar' => 'images/avatar/avatar1.jpg', 'rating' => 5, 'comment' => 'Tôi đã giới thiệu cho nhiều người thân. Hoàn toàn hài lòng!'],
                ['name' => 'Vũ Quang Trung', 'avatar' => 'images/avatar/avatar2.jpg', 'rating' => 4, 'comment' => 'Chi phí hợp lý, tư vấn rõ ràng trước điều trị, không phát sinh chi phí ẩn.'],
                ['name' => 'Lê Thu Hà', 'avatar' => 'images/avatar/avatar1.jpg', 'rating' => 5, 'comment' => 'Tôi từng sợ đến nha khoa, nhưng ở đây thì rất nhẹ nhàng và dễ chịu.'],
                ['name' => 'Đỗ Mạnh Cường', 'avatar' => 'images/avatar/avatar2.jpg', 'rating' => 5, 'comment' => 'Đăng ký nhanh gọn, được hỗ trợ tận tình từ lúc đến đến lúc về.'],
                ['name' => 'Nguyễn Hồng Nhung', 'avatar' => 'images/avatar/avatar1.jpg', 'rating' => 5, 'comment' => 'Kết quả điều trị đúng như cam kết. Tôi rất hài lòng với lựa chọn của mình.'],
                ['name' => 'Lâm Quốc Bảo', 'avatar' => 'images/avatar/avatar2.jpg', 'rating' => 4, 'comment' => 'Đội ngũ bác sĩ có tay nghề cao, mình cảm nhận rõ sự chuyên nghiệp.'],
                ] as $item)
            <div class="swiper-slide">
                <div class="testimonial-item">
                <div class="testimonial-avatar">
                    <img src="{{ asset($item['avatar']) }}" alt="{{ $item['name'] }}">
                </div>
                <p class="testimonial-comment">"{{ $item['comment'] }}"</p>
                <div class="testimonial-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fa{{ $i <= $item['rating'] ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                    <strong class="testimonial-name">{{ $item['name'] }}</strong>
                </div>
            </div>
            @endforeach
        </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
<section class="section sliderAfter">
    <div class="container">
        <h2 class="section-title">Trước & Sau</h2>
        <p class="text-center">Sự khác biệt trước và sau khi đến {{ $setting->name }}</p>

        {{-- Tabs --}}
        <ul class="nav nav-pills mb-4 sliderAfter-tab justify-content-center" id="slider-tab" role="tablist">
            @foreach($sliders as $index => $item)
                <li class="nav-item">
                    <a 
                        class="nav-link {{ $loop->first ? 'active' : '' }}" 
                        id="tab-{{ $index }}-tab"
                        data-toggle="pill"
                        href="#tab-{{ $index }}"
                        role="tab"
                        aria-controls="tab-{{ $index }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    >
                        {{ $item->title }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Tab content --}}
        <div class="tab-content sliderAfter-content" id="slider-tabContent">
            @foreach($sliders as $index => $item)
                <div 
                    class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                    id="tab-{{ $index }}" 
                    role="tabpanel" 
                    aria-labelledby="tab-{{ $index }}-tab"
                >
                    <x-slider-after 
                        :before="$item->before_image" 
                        :after="$item->after_image" 
                        width="100%" 
                    />
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="section partner">
    <div class="container">
        <h2 class="section-title">Báo chí nói gì về chúng tôi</h2>
    </div>
</section>
<section class="section certificate px-0">
    <h2 class="section-title bg-primary text-light py-2">Chứng chỉ Nha Khoa</h2>
    <div class="container">
        <div class="swiper certificate-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@foreach($homeCategories as $postHome)
    @php
        $posts = $postHome->posts ?? collect();
        $featured = $posts->first();
        $others = $posts->slice(1, 5); // tối đa 5 bài bên phải
    @endphp

    @if($featured)
    <section class="section posts">
        <div class="container">
            <h2 class="section-title">{{ $postHome->name }}</h2>
            <div class="row posts-wrapper">
                <div class="col-md-7">
                    <a href="{{ route('slug.resolve', $featured->slug) }}">
                        <div class="posts-left d-flex flex-column">
                            <div class="posts-left__image mb-3">
                                <img src="{{ asset($featured->image) }}" alt="{{ $featured->title }}" class="img-fluid w-100" style="border-radius: 8px;">
                            </div>
                            <p class="posts-left__title fw-bold" style="font-size: 20px;">{{ $featured->title }}</p>
                            <div class="posts-left__description text-muted">
                                {{ \Illuminate\Support\Str::limit(strip_tags($featured->description), 120) }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-5">
                    <div class="posts-right">
                        @foreach($others as $post)
                        <a href="{{ route('slug.resolve', $post->slug) }}" class="d-flex mb-3 posts-right__item" style="gap: 10px; text-decoration: none;">
                            <div class="posts-right__item-image" style="flex-shrink: 0;">
                                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" style="width: 100px; height: 70px; object-fit: cover; border-radius: 6px;">
                            </div>
                            <div class="posts-right__item-info">
                                <p class="posts-right__title mb-1 text-dark" style="font-weight: 500;">{{ $post->title }}</p>
                                <small class="text-muted">{{ $post->created_at->format('d/m/Y') }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
                <div class="text-center my-3">
                    <a href="{{route('slug.resolve',$postHome->slug)}}}" class="btn btn-primary">Xem chi tiết</a>
                </div>
        </div>
    </section>
    @endif
@endforeach

<div class="section contact" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 box-shadow bg-light mb-4">
                <h2 class="section-title text-center my-4">Liên hệ với chúng tôi</h2>
                <form id="contact-form" action="{{ route('contact.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email (không bắt buộc)</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="message">Nội dung liên hệ</label>
                        <textarea name="message" id="message" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary">Gọi cho tôi</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 d-none d-block">
                <div class="contact-info__image">
                    <img src="{{asset('images/setting/PNG3.png')}}" alt="Nha khoa Bani">
                    <p class="">{{$setting->name}}</p>
                </div>
                <p class="contact-info__text">
                    Nha Khoa Bani là một hệ thống phòng khám răng thẩm mỹ uy tín tại Việt Nam, nổi tiếng với các dịch vụ chăm sóc răng miệng cao cấp.
                </p>
                <div class="contact-info__button">
                    <a href="" class="w-100 btn btn-light rounded-pill d-block mb-3">{{$setting->phone}}</a>
                    <a href="" class="w-100 btn btn-primary rounded-pill d-block mb-3">Chat ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.frontend.popup')
@endsection
        @push('js')
        <script src="{{asset('vendor/glightbox/js/glightbox.min.js')}}?{{time()}}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const lightbox = GLightbox({
                    selector: '.glightbox'
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script>
    // Custom rule kiểm tra số điện thoại Việt Nam
            $.validator.addMethod("phoneVN", function (value, element) {
                return this.optional(element) || /^(0[3|5|7|8|9])[0-9]{8}$|^\+84[3|5|7|8|9][0-9]{8}$/.test(value);
            }, "Số điện thoại không hợp lệ");

            $(document).ready(function () {
                $('#contact-form').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 2
                        },
                        phone: {
                            required: true,
                            phoneVN: true
                        },
                        email: {
                            email: true
                        },
                        content: {
                            maxlength: 1000
                        }
                    },
                    messages: {
                        name: {
                            required: "Vui lòng nhập họ và tên",
                            minlength: "Tên quá ngắn"
                        },
                        phone: {
                            required: "Vui lòng nhập số điện thoại",
                            phoneVN: "Số điện thoại không hợp lệ (ví dụ: 098xxxxxxx)"
                        },
                        email: {
                            email: "Email không hợp lệ"
                        },
                        message: {
                            maxlength: "Ý kiến không vượt quá 1000 ký tự"
                        }
                    },
                    errorElement: 'small',
                    errorClass: 'text-danger',
                    highlight: function (element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
        <script>
    const teamSwiper = new Swiper('.team-swiper', {
        slidesPerView: 1,
        centeredSlides: true,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 3,
            }
        }
    });
</script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper('.testimonial-swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                    576: {
                        slidesPerView: 1,
                    },

                }
            });
        });
    </script>

    @endpush