@extends('layouts.master')
@section('content')
    @include('Admin.Products.views.purchase_code_form')
    <table class="table table-bordered table-stripe">
        <thead>
            <tr>
                <th>Product</th>
                <th>Code</th>
                <th>Password</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if ($codes->isEmpty())
                <tr>
                    <td colspan="4">
                        <center>
                            <i>You haven't generated any codes yet.</i>
                        </center>
                    </td>
                </tr>
            @else
                @foreach ($codes as $code)
                    <tr>
                        <td>{{ $code->product->name }}</td>
                        <td>{{ $code->code }}</td>
                        <td>{{ $code->password }}</td>
                        <td>{{ ($code->status <= 0) ? 'Available' : 'Used' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@stop