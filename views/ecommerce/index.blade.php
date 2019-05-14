@extends('layouts.members')
@section('plugin_css')
    <link rel="stylesheet" href="{{ asset('public/assets/member/style.css') }}">
@stop
@section('content')
    <div class="content row">
        <div class="col-12">
            <div class="slider">
                <img class="w-100" src="assets/img/slide.png" alt="">
            </div>
        </div>
        <div class="col-12 product">
            <div class="row">
                @foreach($products as $key => $product)
                    <div class="col-2">
                        <div class="card border-light p-3">
                            <a href="{{ URL::to('/member/products/'.$product->slug) }}"><img class="card-img-top" src="{{ asset('public/products/'.$product->image) }}" alt=""></a>
                            <h5 class="card-title mt-3">{{ $product->name }}</h5>
                            <a class="price mb-0">PHP. {{ number_format($product->rebates, 2) }}</a>
                            <a class="price mb-0">PHP. {{ number_format($product->price, 2) }}</a>
                        </div>
                    </div>
                    @if($key+1%5 == 0)
                        </div>
                        <div class="row">
                    @endif
                @endforeach
            </div>
            {{ $products->render() }}
        </div>
    </div>
@stop