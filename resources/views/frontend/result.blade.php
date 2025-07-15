@extends('layouts.master')
@section('title', 'Kết quả tìm kiếm')

@section('content')
<section class="section py-4">
    <div class="container">
        {{-- Breadcrumb --}}
        <x-frontend.breadcrumb :items="[
            ['label' => 'Tìm kiếm'],
            ['label' => "Từ khóa: \"$keyword\""]
        ]" />

        <h1 class="mb-4">Kết quả tìm kiếm cho: <strong>{{ $keyword }}</strong></h1>

        @if($posts->count())
            @foreach($posts as $post)
            <div class="mb-4 border-bottom pb-3">
                <a href="{{ route('frontend.post.detail', $post->slug) }}" class="d-block mb-2">
                    <h4 class="mb-1">{{ $post->title }}</h4>
                </a>
                <div class="small text-muted mb-2">{{ $post->created_at->format('d/m/Y') }}</div>
                <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
            </div>
            @endforeach

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <p>Không tìm thấy kết quả nào phù hợp với từ khóa "<strong>{{ $keyword }}</strong>".</p>
        @endif
    </div>
</section>
@endsection
