@extends('layouts.members')
@section('content')
    @include('Admin.Products.views.purchase_code_form')
    <table class="table table-bordered table-stripe">
        <thead>
        <tr>
            <th>Product</th>
            <th>Code</th>
            <th>Password</th>
            <th>Status</th>
            <th>Option</th>
        </tr>
        </thead>
        <tbody>
        @if ($codes->isEmpty())
            <tr>
                <td colspan="4">
                    <center>
                        <i>You haven't bought any codes yet.</i>
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
                    <td>
                        @if ($code->status <= 0)
                            <a class="btn btn-primary btn-sm" href="{{ url('member/purchases/encode/'.$code->id) }}">Encode</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <center>
        {{ $codes->render() }}
    </center>
@stop