
<table class="table table-bordered table-hover">
    <thead>
        <th>{{ Lang::get('products.name') }}</th>
        <th>{{ Lang::get('products.amount') }}</th>
        <th>{{ Lang::get('products.rebates') }}</th>
    </thead>
    <tbody>
    <?php
        $purchaseTotal = 0;
        $rebatesTotal = 0;
    ?>
        @if(!$purchases->isEmpty())
            @foreach ($purchases as $row)
                @foreach ($row->purchaseProducts as $purchase)
                    <tr>
                        <td>{{ $purchase->product->name }}</td>
                        <td>{{ number_format($purchase->product->price, 2) }}</td>
                        <td>{{ ($purchase->rebatesDetails != null) ? number_format($purchase->rebatesDetails->amount, 2) : 0; }}</td>
                    </tr>
                    <?php
                        $purchaseTotal += $purchase->product->price;
                        $rebatesTotal += ($purchase->rebatesDetails != null) ? $purchase->rebatesDetails->amount : 0;
                    ?>
                @endforeach
            @endforeach
        @endif
            <tr class="success">
                <td><center>{{ Lang::get('products.total') }}</center></td>
                <td>{{ number_format($purchaseTotal, 2) }}</td>
                <td>{{ number_format($rebatesTotal, 2) }}</td>
            </tr>
    </tbody>
</table>