<?php
set_time_limit(3000);
?>
<?php
  $date_from = $maintenanceexcel['date_from'];
  $date_to =  $maintenanceexcel['date_to'];
  $maintenance_details = $maintenanceexcel['maintenance_details'];
  $start_date = date("F d, Y", strtotime($date_from));
  $end_date = date("F d, Y", strtotime($date_to));
  $total = 0;
  $my_c_total = 0;
  ?>

<table>
    <tr>
      <th colspan="5">Monthly Maintenance History ({{$start_date}} - {{$end_date}} )</th>
    </tr>
    <tr>
        <th>Full Name</th>
        <th>Username</th>
        <th>Account ID.</th>
        <th>From</th> 
        <th>CBU</th>
        <th>MY-C</th>
        <th>Date</th>
    </tr>
    <tbody>
      @if (!empty($maintenance_details))
        @foreach ($maintenance_details as $details)
            <?php
              $firstname = (!empty($details['first_name'])) ? $details['first_name'] : '';
              $lastname = (!empty($details['last_name'])) ? $details['last_name'] : '';
              $username = (!empty($details['username'])) ? $details['username'] : '';
              $account_id = (!empty($details['account_id'])) ? $details['account_id'] : '';
              $amount = (!empty($details['CBU'])) ? $details['CBU'] : 0;
              $date = (!empty($details['created_at'])) ? $details['created_at'] : '';
              $from = $details['from'];
              $my_c_total += $details['my_c'];
              $total += $amount;
            ?>
            <tr>
                <td>{{ $firstname.' '.$lastname }}</td>
                <td>{{ $username }}</td>
                <td>{{ $account_id }}</td>
                <td>{{ $from }}</td>
                <td>{{ number_format($amount, 2) }}</td>
                <td>{{ number_format($details['my_c'], 2) }}</td>
                <td>{{ $date }}</td>
            </tr>
        @endforeach
      @else
        <tr>
            <td colspan="6">
                <center>
                    <i>No Maintenance Report Found</i>
                </center>
            </td>
        </tr>
      @endif
    </tbody>
    <tfoot>
        <tr class="strong">
            <td colspan="4">Total</td>
            <td>{{ number_format($total, 2) }}</td>
            <td>{{ number_format($my_c_total, 2) }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

