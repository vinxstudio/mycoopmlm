@extends('layouts.master')
@section('content')
    <a href="{{ url('admin/products/form') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
    <div class="col-md-12 row mt-15">
        <table class="table table-bordered table-striped">
            <thead>
                <th>{{ Lang::get('products.name') }}</th>
                <th>{{ Lang::get('products.price') }}</th>
                <th>{{ Lang::get('products.global_pool') }}</th>
                <th>{{ Lang::get('products.rebates_percentage') }}</th>
                <th></th>
            </thead>
            <tbody>
                @if ($products->isEmpty())
                    <tr>
                        <td colspan="10">
                            <center>
                                <i>{{ Lang::get('products.no_records') }}</i>
                            </center>
                        </td>
                    </tr>
                @else
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ ucwords($product->name) }}</td>
                            <td>{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->global_pool.'% ( '.number_format(calculatePercentage($product->global_pool, $product->price), 2).' )' }}</td>
                            <td>{{ $product->rebates }}</td>
                            <td>
                                <a href="{{ url('admin/products/form/'.$product->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> {{ Lang::get('labels.update') }}</a>
                                <a href="{{ url('admin/products/delete/'.$product->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{ Lang::get('labels.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $products->render() }}
    </div>
@stop