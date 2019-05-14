<table class="table table-bordered table-hover table-striped" id="flushout_table">
    {{-- <col width="5%;"> --}}
    <?php 
        $total_amount = 0;
    ?>
    <thead>
        <tr>
            <th>Left Account ID.</th>
            <th>Left Full Name</th>
            <th>Left Package</th>
            <th>Left Date Encoded</th>
            <th>Right Account ID.</th>
            <th>Right Full Name</th>
            <th>Right Package</th>
            <th>Right Date Encoded</th>
            <th>Source</th>
            <th>Matching Bonus</th>
            <th>Pairing Date</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($flushout_list))
            @foreach($flushout_list as $flushout)
                <?php $total_amount = $total_amount + $flushout['mb']; ?>
                <tr>
                    <td>{{$flushout['left_account_id']}}</td>
                    <td>{{$flushout['left_name']}}</td>
                    <td>{{$flushout['left_package']}}</td>
                    <td>{{$flushout['left_account_date']}}</td>
                    <td>{{$flushout['right_account_id']}}</td>
                    <td>{{$flushout['right_name']}}</td>
                    <td>{{$flushout['right_package']}}</td>
                    <td>{{$flushout['right_account_date']}}</td>
                    <td>{{$flushout['source']}}</td>
                    <td>{{$flushout['mb']}}</td>
                    <td>{{$flushout['date']}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">
                    <center>
                        <i>No Flushout found</i>
                    </center>
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr class="strong">
            <td colspan="9">Total</td>
            <td colspan="1">{{ number_format($total_amount, 2) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
