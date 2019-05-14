<table class="dataTable table table-bordered table-hover table-striped">
    <?php
        $payments = $registration['payments'];
        $date_from = $registration['date_from'];
        $date_to = $registration['date_to'];
        $date = ($date_from && $date_to)? "From : ".$date_from." - To : ".$date_to:"All"
    ?>
    <tr>
        <th colspan="10">Registration History ({{ $date }})</th>
    </tr>
    <tr>
		<th>Batch ID</th>
        <th>Account ID</th>
		<th>Account Code</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Teller</th>
        <th>Branch</th>
        <th>Package Type</th>
		<th>Entry Fee</th>
        <th>Encoded on</th>
        
    </tr>
        
        @foreach ($payments as $payment)
            <?php 
                if($payment->bname){
                    $t_name = explode(' - ',$payment->bname);
                    $name = $t_name[1];
                    $branch = $payment->bname;
                }else{
                    $name = 'Head Office';
                    $branch = "Cebu People's Coop Head Office";
                }
                ?>
                <tr>
                    <td>{{ $payment->name }}</td>
                    <td>{{ $payment->account_id }}</td>
                    <td>{{ $payment->code}}</td>
                    <td>{{ $payment->username }}</td>
                    <td>{{ $payment->first_name }} {{ $payment->last_name }}</td>
                    <td>{{ $name }} </td>
                    <td>{{ $branch }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->entry_fee }}</td>
                    <td>{{ $payment->created_at }}</td>
                  
                </tr>
            </tr>
			
        @endforeach
</table>
