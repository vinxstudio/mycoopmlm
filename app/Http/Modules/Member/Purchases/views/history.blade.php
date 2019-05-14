@extends('layouts.members')
@section('content')

    <div class="col-md-12 col-xs-12">
        {{ view('widgets.purchases.table')
        ->with([
            'purchases'=>$purchases
        ])->render(); }}

        <center>{{ $purchases->render() }}</center>
    </div>

@stop