@push('css')
<style>
    
</style>
@endpush

<div class="bottom-contact">
    <a href="#" class="bottom-contact_link">
    	<img src="{{asset("images/setting/Icon_of_Zalo.svg")}}" alt="zalo contact" width="40" height="40">
    </a>
    <a href="#" class="bottom-contact_link">
    	<img src="{{asset("images/setting/Facebook_Messenger_logo_2020.svg")}}" alt="" width="40" height="40">
    </a>
    <a href="#" class="bottom-contact_link">
    	<img src="{{asset("images/setting/youtube.svg")}}" alt="" width="40" height="40">
    </a>
    <a href="#" class="bottom-contact_link">
    	<img src="{{asset("images/setting/phone.svg")}}" alt="" width="40" height="40">
    </a>
</div>
<div class="mobile-bottom-nav d-flex align-items-center justify-content-between d-md-none px-2 py-1">
    {{-- Menu trái --}}
    <a href="#danh-muc" class="nav-item text-center">
        <i class="fa-solid fa-list"></i>
        <div class="nav-label">Danh mục</div>
    </a>
    <a href="tel:{{ $setting->phone ?? '0123456789' }}" class="nav-item text-center">
        <i class="fa-solid fa-phone"></i>
        <div class="nav-label">Gọi</div>
    </a>

    {{-- Trang chủ ở giữa --}}
    <a href="{{ url('/') }}" class="nav-item text-center">
        <i class="fa-solid fa-home"></i>
        <div class="nav-label">Trang chủ</div>
    </a>

    {{-- Menu phải --}}
    <a href="https://zalo.me/" class="nav-item text-center">
        <i class="fa-solid fa-comments"></i>
        <div class="nav-label">Zalo</div>
    </a>

    {{-- Nút lên đầu trang (vẫn trong nav) --}}
    <a href="#" class="nav-item gotop-mobile text-center" title="Lên đầu trang">
        <i class="fa-solid fa-arrow-up"></i>
        <div class="nav-label">Top</div>
    </a>
</div>


<div class="d-none d-md-inline-block">
	<a href="#" class="gotop">
        <i class="fa-solid fa-arrow-up"></i>
    </a>
</div>
<footer id="footer" class="footer-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-5 col-sm-12">
				<div class="footer-item">
					<p class="footer-item_title">Thông tin liên hệ</p>
					<div class="footer-logo text-center">
						<img src="{{asset($setting->logo)}}" alt="{{$setting->name}}">
					</div>
					<ul class="footer-item_list">
						<li class="item_list">
							<h3><strong>{{$setting->name}}</strong></h3>
						</li>
						<li class="item_list">
							<i class="fa-solid fa-location-dot"></i>
							<span>Trụ sở chính: {{$setting->address}}</span>
						</li>
						<li class="item_list">
							<i class="fa-solid fa-phone"></i>
							Điện thoại: <a href="tel:{{$setting->phone}}">{{$setting->phone}}</a>
						</li>
						<li class="item_list">
							<i class="fa-regular fa-envelope"></i>
							Email:<a href="mailto:{{$setting->email}}">{{$setting->email}}</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-12 col-md-3 col-sm-12">
				<div class="footer-item">
					<p class="footer-item_title">Dịch vụ</p>
					<ul class="footer-item_list">
						<li class="item_list">
							<a href=""></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-12 col-md-4 col-sm-12">
				<div class="footer-item">
					<p class="footer-item_title">Fan Page</p>
					<div>
						<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fnhakhoabani&tabs&width=340&height=70&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=7715792338477816" width="340" height="70" style="border:none;overflow:hidden;max-width: 100%" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>				
<div class="copyright bg-light">
	<div class="container">
		<div class="row">
			<p class="text-center">© Bản quyền thuộc về {{$setting->name}}</p>
		</div>
	</div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        const gotop = $('.gotop');

        // 1. Show go-to-top when scroll
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 200) {
                gotop.addClass('show');
            } else {
                gotop.removeClass('show');
            }
        });

        // 2. Smooth scroll to top
        $('.gotop').on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
    });
</script>
@endpush
		