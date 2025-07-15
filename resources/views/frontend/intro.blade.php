@extends('layouts.master')
@section('title', 'Giới thiệu Ruby Queen')

@section('content')
<section class="section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title text-uppercase">Về {{$setting->name}}</h1>
        </div>

        <div class="content">
            {!!$intro->content!!}
        </div>
    </div>
</section>
@endsection
