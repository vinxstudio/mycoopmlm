<span>ACCOUNT SUMMARY</span>
<table class="dataTable table table-bordered table-hover table-striped">
    <?php
        $t_dri = 0;
        $t_mbi = 0;
        $t_rend_binary_income = 0;
        $t_gci = 0; 
    ?>
    <thead>
        <th>UserName</th>
        <th>Direct Referral Income</th>
        <th>Matching Sales Bonus Income</th>
        <th>Redundant Binary Income</th>
        <th>Gift Certificate</th>
        <th>Travel Incentives</th>
        <th>Car Program</th>
        <th>Gross Income</th>
    </thead>
    <tbody>
        @if(!empty($account_summary))
            @foreach($account_summary as $val)
             <?php
                $t_dri = $t_dri + $val['DRI'];
                $t_mbi = $t_mbi + $val['MSBI'];
                $t_rend_binary_income = $t_rend_binary_income + $val['rend_income'];
                $t_gci = $t_gci + $val['GC'];
                $bg = ($theUser->username == $val['username'])? 'bg-primary-active':'';
            ?>
                <tr class="{{ $bg }}">
                    <td>{{ $val['username'] }}</td>
                    <td>
                        @if( $val['DRI'] != 0 )
                            <a href="direct-referral/{{$val['acc_id']}}/0/0">{{number_format($val['DRI'],2) }}</a>
                        @else
                            {{$val['DRI']}}
                        @endif
                    </td>
                    <td>
                        @if($val['MSBI'] != 0)
                            <a href="matching-bonus/{{$val['acc_id']}}/0/0">{{number_format($val['MSBI'],2) }}</a>
                        @else
                            {{$val['MSBI']}}
                        @endif
                    </td>   
                    <td>
                        @if(!empty($val['rend_income']) && $val['rend_income'] != 0)
                            <a href="redundant-binary/{{ $val['acc_id'] }}/0/0">{{ number_format($val['rend_income'], 2) }}</a>
                        @else
                            0
                        @endif
                    </td>
                    <td>{{ $val['GC'] }}</td>
                    <td>NONE</td>
                    <td>NONE</td>
                    <td>{{ number_format( $val['GI'],2) }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr class="strong">
            <?php $total_GI = $t_dri + $t_mbi + $t_rend_binary_income; ?>
            <td>Total</td>
            <td>{{ number_format($t_dri,2) }}</td>
            <td>{{ number_format($t_mbi,2) }}</td>
            <td>
                {{ number_format($t_rend_binary_income, 2) }}
            </td>
            <td>{{ $t_gci}}</td>
            <td colspan="2"></td>
            <td>{{ number_format($total_GI,2) }}</td>
        </tr>
    </tfoot>
</table>