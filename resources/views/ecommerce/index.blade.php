@extends('layouts.members')
@section('plugin_css')
    <link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}">
@stop
@section('content')
    <div class="content row">
        <div class="col-12">
            <div class="slider">
                <img class="w-100" src="{{ asset('public/assets/member/img/slide.png') }}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="alert alert-danger fade in" style="display: none;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error!</strong> Product not added to cart.
            </div>
        </div>
        <div class="col-12 product">
            <div class="row">
                @foreach($products as $key => $product)
                    <div class="col-2">
                        <div class="card border-light p-3">
                            <a href="{{ URL::to('/member/products/'.$product->slug) }}"><img class="card-img-top" src="{{ asset('public/products/'.$product->image) }}" alt=""></a>
                            <h5 class="card-title mt-3">{{ $product->name }}</h5>
                            <a class="price mb-0">MP: PHP. {{ number_format($product->rebates, 2) }}</a>
                            <a class="price mb-0">SRP: PHP. {{ number_format($product->price, 2) }}</a>
                        </div>
                        <button class="w-100 p-3 btn rounded-0 orange bg btnBuyNow" type="button" value="{{$product->slug}}" >BUY NOW</button>
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
@section('plugin_js')
<script>
$(document).ready(function(){
    $('.btnBuyNow').on('click', function(){
        $('#btnBuyNow').attr('disabled', true);
        
        $.ajax({
            type: "POST",
            url: "{{url('member/products/addToCart')}}" + "/" + $(this).val(),
            data: { 
                quantity: 1
            },
            success: function(data) {
                    window.location.href = '/member/cart';
            },
            error: function(){
                $('#btnBuyNow').attr('disabled', false);
                $('.alert-danger').css('display', 'block');
            }
        });
    });
});
</script>
@stop