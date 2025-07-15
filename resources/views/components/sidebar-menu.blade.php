@php
    $menu = config('menu');
@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach ($menu as $item)
        @php
            $hasSub = !empty($item['submenu']);
            $open = $hasSub ? is_open_menu($item['submenu']) : '';
            $active = $hasSub ? ($open ? 'active' : '') : (isset($item['route']) ? is_active_menu($item['route']) : '');
            $url = $hasSub ? '#' : (isset($item['route']) ? route($item['route'], $item['params'] ?? []) : ($item['url'] ?? '#'));
        @endphp

        <li class="nav-item {{ $hasSub ? 'has-treeview' : '' }} {{ $open }}">
            <a href="{{ $url }}" class="nav-link {{ $active }}">
                <i class="nav-icon {{ $item['icon'] }}"></i>
                <p>
                    {{ $item['title'] }}
                    @if ($hasSub)
                        <i class="right fas fa-angle-left"></i>
                    @endif
                </p>
            </a>

            @if ($hasSub)
                <ul class="nav nav-treeview">
                    @foreach ($item['submenu'] as $sub)
                        @php
                            $routeName = $sub['route'] ?? null;
                            $params = $sub['params'] ?? [];
                            $url = $routeName ? route($routeName, $params) : '#';
                            $isActive = $routeName ? is_active_menu($routeName) : '';
                        @endphp
                        <li class="nav-item">
                            <a href="{{ $url }}" class="nav-link {{ $isActive }}">
                                <i class="{{ $sub['icon'] ?? 'far fa-circle' }} nav-icon"></i>
                                <p>{{ $sub['title'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
