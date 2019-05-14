@extends('layouts.teller')
@section('content')
    @include('Teller.ActivationCodes.views.form')

    <!--div class="col-md-12 mt-15">
        <table class="table table-bordered table-stiped table-hover">
            <thead>
                <th>Batch ID</th>
                <th>Total Codes</th>
                <th>Available Codes</th>
                <th>Code Type</th>
            </thead>
            <tbody>
                @if ($batches->isEmpty())
                    <tr>
                        <td colspan="3">
                            <center>
                                <i>No activation codes were made yet.</i>
                            </center>
                        </td>
                    </tr>
                @else
                    @foreach($batches as $batch)
                        <tr>
                            <td><a href="{{ url('admin/activation-codes/view-batch/'.$batch->id) }}">{{ $batch->name }}</a></td>
                            <td>{{ $batch->activationCodes()->count() }}</td>
                            <td>{{ $batch->activationCodes()->where('status', 'available')->count() }}</td>
                            <td>{{ $batch->type }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $batches->render() }}
    </div-->
@stop