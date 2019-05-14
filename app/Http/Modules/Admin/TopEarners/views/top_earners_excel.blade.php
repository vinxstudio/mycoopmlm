<?php
    ini_set('max_execution_time', 5000);
    ini_set('memory_limit','256M');
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>#.</th>
                <th>Full Name</th>
                <th>User Name</th>
                <th>Account ID.</th>
                <th>Package Type</th>
                <th>Total Gross Earnings</th>
                <th>Date Encoded</th>
            </tr>
            <?php $counter = 1; ?>
            @if(!empty($gross))
                @foreach ($gross as $member)
                    <tr>
                        <td>{{$counter}}</td>
                        <td>{{strtoupper($member->full_name)}}</td>
                        <td>{{$member->username}}</td>
                        <td>{{strtoupper($member->account_id)}}</td>
                        <td>{{$member->package_type}}</td>
                        <td>{{number_format($member->gross_income, 2)}}</td>
                        <td>{{$member->user_created}}</td>
                    </tr>
                    <?php $counter++; ?>
                @endforeach
            @endif
        </table>
    </body>
</html>
