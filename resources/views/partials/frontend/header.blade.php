<header class="header">
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <div class="header-logo">
                <a href="{{ route('home') }}" title="{{ $setting->name }}">
                    <img src="{{ $setting->logo }}" alt="{{ $setting->name }}" title="{{ $setting->name }}" width="180" height="70">
                </a>
            </div>

            <button class="menu-toggle d-block d-md-none" aria-label="Mở menu">
                <i class="fa fa-bars"></i>
            </button>

            <div class="header-top_right d-none d-md-flex">
                {{-- Form tìm kiếm --}}
                <div class="right-form">
                    <form action="{{ route('frontend.post.search') }}" method="GET">
                        @csrf
                        <div class="input-group">
                            <button class="btn btn-default" type="submit" aria-label="Tìm kiếm">
                                <i class="fa fa-search"></i>
                            </button>
                            <input type="text" name="keyword" placeholder="Nhập thông tin tìm kiếm" aria-label="Tìm kiếm">
                        </div>
                    </form>
                </div>

                {{-- Đặt hẹn --}}
                <button class="btn btn-primary" title="Đặt lịch hẹn">
                    <i class="fa fa-calendar-check"></i>
                    <span>Đặt lịch hẹn</span>
                </button>

                {{-- Gọi điện --}}
                <a href="tel:{{ trim($setting->phone) }}" title="Gọi tư vấn">
                    <i class="fa fa-phone"></i>
                    <span>{{ $setting->phone }}</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Thanh điều hướng --}}
    <nav class="main-nav">
        <div class="container">
            <ul class="menu">
                {{-- Giới thiệu --}}
                <li class="menu-item">
                    <a href="{{ url('gioi-thieu') }}" class="menu-item_link">Giới thiệu</a>
                </li>

                {{-- Dịch vụ (lấy từ ViewShare) --}}
                @foreach($dichvuMenu as $dv)
                    <li class="menu-item {{ $dv->children->isNotEmpty() ? 'has-sub' : '' }}">
                        <a href="{{ route('slug.resolve', $dv->slug) }}" class="menu-item_link">
                            {{ $dv->name }}
                        </a>

                        @if($dv->children->isNotEmpty())
                            <ul class="sub-menu">
                                @foreach($dv->children as $child)
                                    <li class="menu-item">
                                        <a href="{{ route('slug.resolve', $child->slug) }}" class="menu-item_link">
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                @foreach($postMenu as $postM)
                {{-- Tin tức --}}
                <li class="menu-item">
                    <a href="{{ route('slug.resolve', $postM->slug) }}" class="menu-item_link">
                    {{$postM->name}}
                    </a>
                </li>
                @endforeach
                {{-- Liên hệ --}}
                <li class="menu-item">
                    <a href="{{ route('contact.show') }}" class="menu-item_link">Liên hệ</a>
                </li>
            </ul>
        </div>
    </nav>


</header>

@push('js')
<script>
    $(document).ready(function () {
        const mainNav = $('.main-nav');
        const stickyOffset = mainNav.offset().top;
        let lastScrollTop = 0;

        // Sticky + hide/show on scroll
        $(window).on('scroll', function () {
            let scrollTop = $(this).scrollTop();

            if (scrollTop > stickyOffset) {
                mainNav.addClass('is-sticky');
            } else {
                mainNav.removeClass('is-sticky');
            }
        });

        $('.menu-toggle').on('click', function () {
            $('#main-nav').toggleClass('active');
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#main-nav, .menu-toggle').length) {
                $('#main-nav').removeClass('active');
            }
        });

        $('.has-sub > a').on('click', function (e) {
            if ($(window).width() < 769) {
                e.preventDefault();
                $(this).parent().toggleClass('open');
            }
        });
    });
</script>
@endpush
