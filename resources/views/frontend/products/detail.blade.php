@extends('layouts.master')
@section('title','sản phẩm a')
@push('css')
<link rel="stylesheet" href="{{asset('css/product.css')}}">
@endpush
@section('content')
	<div id="product-wrapper">
		<div class="container">
			<x-frontend.breadcrumb :items="[
				// ['label' => 'Danh mục', 'url' => route('categories.index')],
				// ['label' => 'Điện thoại', 'url' => route('categories.show', 'dien-thoai')],
				['label' => 'iPhone 15 Pro Max']
			]" />
			@php
    $images = [
        asset('images/setting/banner-001.jpg'),
        asset('images/setting/banner-002.jpg'),
        asset('images/setting/banner-003.jpg'),
        asset('images/setting/banner-004.jpg'),
    ];
@endphp
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<div class="swiper mainSwiper mb-3">
						<div class="swiper-wrapper">
							@foreach ($images as $img)
							<div class="swiper-slide">
								<img src="{{ $img }}" class="img-fluid w-100" alt="Slide">
							</div>
							@endforeach
						</div>
					</div>

					<div class="swiper thumbSwiper">
						<div class="swiper-wrapper">
							@foreach ($images as $img)
							<div class="swiper-slide">
								<img src="{{ $img }}" class="img-fluid" alt="Thumb" style="max-height: 100px;">
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-12">
					<h2>Công Trình C Vân – Cỗ Mễ – Tp. Bắc Ninh</h2>
					<div class="des-project">
						
					</div>
					<div class="form-project">
						<h3>Khuyến mãi đặc biệt giảm 100% phí thiết kế khi thi công nội thất</h3>
						<div class="form-project-content">
							<div class="form" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" name="name" placeholder="Họ và tên">
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
								</div>
								<button class="btn btn-danger">Đăng ký</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<section class="section productDetail">
				<div class="section-title">Dự án nổi bật</div>
				<div class="section-content">
					<div class="row">
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						<div class="col-6 col-md-4">
							<a href="" class="project-link">
								<div class="project-box">
									<div class="project-img">
										<img src="{{asset('images/setting/banner-001.jpg')}}" alt="">
									</div>
									<p class="project-title">Dự án một</p>
								</div>
							</a>
						</div>
						
					</div>
				</div>		
			</section>
		</div>
	</div>			
@endsection
@push('js')
<script>
    const thumbSwiper = new Swiper(".thumbSwiper", {
        spaceBetween: 10,
        slidesPerView: 8,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            768: { slidesPerView: 8 },
            375: { slidesPerView: 4 },
        },
    });

    const mainSwiper = new Swiper(".mainSwiper", {
        spaceBetween: 10,
        loop: true,
        lazy: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: thumbSwiper,
        },
    });
</script>
@endpush