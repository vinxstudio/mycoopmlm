@extends('layouts.members')
@section('content')
<div class="col-md-6 col-xs-12">
	<table class="table table-bordered table-hover">
	    <thead>
	        <th>ID</th>
	        <th>Requester</th>
	        <th>Type</th>
	        <th>Status</th>
	        <th>Cost (If any)</th>
	        <th>Amount</th>
	        <th>Purchased Date</th>
	        <th>View</th>
	    </thead>

	    <tbody>
	    	@foreach( $transactions as $transaction)
	            <tr>
	            	<td>{{ $transaction->id }}</td>
	            	<td>{{ $transaction->requester }}</td>
	            	<td>{{ $transaction->details_type }}</td>
	                <td>{{ $transaction->status_string }}</td>
	                <td>{{ isset($transaction->cost)? number_format($transaction->cost, 2) : ""}}</td>
	                <td>{{ isset($transaction->amount)? number_format($transaction->amount, 2) : ""}}</td>
	                <td>{{ $transaction->created_at }}</td>
	                <td><a href="transactions/{{ $transaction->id }}">View</td>
	            </tr>
	        @endforeach
	        <tr class="success">
	        </tr>
	    </tbody>
	</table>
</div>
@stop
