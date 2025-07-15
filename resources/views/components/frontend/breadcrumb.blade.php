@props(['items' => []])

<nav aria-label="breadcrumb" class="text-center">
  <ol class="breadcrumb bg-transparent p-0 m-0 justify-content-center">
    <li class="breadcrumb-item">
      <a href="{{ url('/') }}">Trang chủ</a>
    </li>

    @foreach ($items as $key => $item)
      @if ($loop->last)
        <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
      @else
        <li class="breadcrumb-item">
          <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
      @endif
    @endforeach
  </ol>
</nav>
