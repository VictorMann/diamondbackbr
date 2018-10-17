@extends('templates.master')
@inject('request', 'Illuminate\Http\Request')

@section('title')
    {{ ucfirst($request->segment(1)) }}
@endsection

@section('styles')
<link rel="stylesheet" href="{{ url('/') }}/css/category.css">
@endsection

@section('content')
<section class="container">
    <h1>{{ $request->segment(1) }}</h1>
    <div class="ctn-grade-img">
        @forelse ($produtos as $produto)
        <div class="ctn-product">
            <a href="{{ url('/') . '/' . $produto->slug }}">
                <figure class="product-img">
                    <img src="{{ url('/') }}/imgs/products/{{ $produto->image }}">
                </figure>
                <h3 class="product-name">
                    {{ $produto->titulo }}
                </h3>
            </a>
        </div>
        @empty
            No product
        @endforelse
    </div>
    <div class="text-center">
        {{ $produtos->links() }}
    </div>
</section>
@endsection
