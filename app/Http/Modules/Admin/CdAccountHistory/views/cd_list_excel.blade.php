<?php
    ini_set('max_execution_time', 5000);
    ini_set('memory_limit','256M');
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>Full Name</th>
                <th>User Name</th>
                <th>Role</th>
                <th>Account ID.</th>
                <th>Package Type</th>
                <th>Package Amount</th>
                <th>Total Earnings</th>
                <th>Date Encoded</th>
            </tr>
            @if(!empty($members))
                @foreach ($members as $member)
                    <tr>
                        <td>{{$member->full_name}}</td>
                        <td>{{$member->username}}</td>
                        <td>{{$member->role}}</td>
                        <td>{{$member->account_id}}</td>
                        <td>{{$member->membership_type_name}}</td>
                        <td>{{$member->entry_fee}}</td>
                        <td>{{number_format($member->total_earnings, 2)}}</td>
                        <td>{{$member->created_at}}</td>
                    </tr>
                @endforeach
            @endif
        </table>
    </body>
</html>
