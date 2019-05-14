@extends('layouts.members')
@section('content')
    {{ view('widgets.purchases.form')->with([
        'accounts'=>$accounts,
        'purchaseCode'=>$purchaseCode
    ])->render() }}

    <div class="col-md-6 col-xs-12">
        {{ view('widgets.purchases.table')->with([
            'purchases'=>$purchases
        ])->render() }}
    </div>
@stop