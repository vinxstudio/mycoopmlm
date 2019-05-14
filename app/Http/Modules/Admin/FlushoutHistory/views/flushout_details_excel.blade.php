<?php
    ini_set('max_execution_time', 50000);
?>
<html>
    <body>
        <table border="1">
            <?php 
                $total = 0;
                $owner = $flushoutexcel['owner'];
                $flushout_details =  $flushoutexcel['flushout_details'];
                $overall_total = $flushoutexcel['overall_total'];
            ?>
            <tr>
                <th colspan="5">Full Name : {{ ucwords($owner['owner_name']) }}</th>
            </tr>
            <tr>
                <th colspan="5">Account ID : {{ strtoupper($owner['owner_account_id']) }}</th>
            </tr>
            <tr>
                <th colspan="5">Package : {{ $owner['owner_package'] }} </th>
            </tr>
            <tr>
                <th colspan="5">Total Flushout : {{ $overall_total }} </th>
            </tr>    
            <tr>
                <th></th>
            </tr>    
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
            @if(!empty($flushout_details))
                @foreach($flushout_details as $flushout)
                    <?php $total = $total + $flushout['mb']; ?>
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
                    <td colspan="4">
                        <center>
                            <i>No Flushout found</i>
                        </center>
                    </td>
                </tr>
            @endif
            <tfoot>
                <tr class="strong">
                    <td colspan="9">Total</td>
                    <td colspan="2">{{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
