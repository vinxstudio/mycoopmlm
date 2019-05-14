
{{-- <link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}"> --}}

<style>
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #DDD;
}

</style>

<div class="table-responsive">
    
    <style scoped>
        @import "/public/assets/member/css/style.css";
    </style>
        <table id="activation_table" class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        {{ Lang::get('codes.activation') }}
                    </th>
                    <th>
                        {{ Lang::get('codes.account_id') }}
                    </th>
                    <th>
                        {{ Lang::get('codes.or_number') }}
                    </th>
                    @if (Request::segment(1) != 'member')
                        <th>
                            Teller/Branch
                        </th>
                        <th>
                            Teller Username
                        </th>
                        <th>
                            Payors Name
                        </th>
                        <th>
                            Payment Method
                        </th>
                    @endif
                    <th>
                        {{ Lang::get('codes.paid_amount') }}
                    </th>
                    <th>
                        {{ Lang::get('codes.status') }}</th>
                    <th>
                        {{ Lang::get('codes.type') }}
                    </th>
                    <th>
                        Created At
                    </th>
                    <th>
                        Transferred To
                    </th>
                    <th>
                        {{ Lang::get('codes.receipt') }}
                    </th>
                    @if (Request::segment(1) != 'member')
                        <th>
                            Action
                        </th>
                    @endif
                    <!--th>
                        @if (Request::segment(1) != 'member')
                            {{ Lang::get('codes.type') }}
                        @else
                            {{ Lang::get('labels.action') }}
                        @endif
                    </th-->
                </tr>
            </thead>
            <tbody>
                @if ($codes->isEmpty())
                    <tr>
                        <td colspan="@if(Request::segment(1) != 'member') 14 @elseif(Request::segment(1) == 'member') 8 @endif">
                            <center>
                                <i>{{ Lang::get('codes.no_record') }}</i>
                            </center>
                        </td>
                    </tr>
                @else
                    @foreach($codes as $code)
                        <?php
                            $address = explode("-", $code->name);  
                            $status_color = '';
                            if($code->status == 'available')
                            {
                                $status_color = 'text-success';
                            }
                            else if($code->status == 'used')
                            {
                                $status_color = 'text-warning';
                            }
                            else
                            {
                                $status_color = 'text-danger';
                            }
        
                            $receipt = url() . '/public/uploads/receipt/activation_codes/' . $code->receipt;
                        ?>
                        <tr>
                            <td>{{ $code->code }}</td>
                            <td>{{ $code->account_id }}</td>
                            <td>{{ $code->or_number }}</td>
                            @if(Request::segment(1) != 'member')
                                @if(!empty($code->teller_id))
                                    <td>
                                        {{ $code->first_name.' '.$code->last_name}}
                                        @if (!empty($code->name))
                                            ({{!empty($address[2]) ? $address[2] : '-'}})
                                        @endif
                                    </td>
                                    <td>{{ $code->username }}</td>
                                    {{-- @if(Request::segment(1) == 'teller') --}}
                                    <td>
                                        {{ ($code->payors_name) ? $code->payors_name : 'N \ A' }}
                                    </td>
                                    <td>
                                        {{ ($code->payment_method) ? $code->payment_method : 'N \ A' }}
                                    </td>
                                    {{-- @endif --}}
                                @else
                                <td></td>
                                <td></td>
                                <td>N \ A</td>
                                <td>N \ A</td>
                                @endif
                            @endif
                            <td>{{ number_format($code->membership->entry_fee,2) }}</td>
                            <td class="{{$status_color}}">{{ ucwords($code->status) }}</td>
                            <td>{{ ucwords($code->type) }}</td>
                            <td>{{ /*ucwords($code->created_at)*/  date('F d, Y', strtotime($code->created_at)) }}</td>
                            <td>{{ ucwords($code->transferred_to) }}</td>
                            @if(!empty($code->receipt))
                                <td>
                                    <button class="btn btn-primary btn-sm btn-img" data-src={{ $receipt }}>View</button>
                                </td>
                            @else
                                <td>

                                </td>
                            @endif
                            @if(Request::segment(1) != 'member')
                                @if($code->status == 'available')
                                    <td>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id={{ $code->id }}>
                                            Cancel
                                        </button>
                                    </td>
                                @elseif($code->status == 'cancelled')
                                    <td>
                                        <button class="btn btn-primary btn-sm btn-reason" data-id={{ $code->id }}>
                                            Reason
                                        </button>
                                    </td>
                                @else
                                <td>
                                    
                                </td>
                                @endif
                            @endif          
                            {{-- <td>
                                @if (Request::segment(1) != 'member')
                                    
                                    {{ ucwords($code->type) }}
                                @else
                                    @if ($code->status == 'available')
                                        <a class="btn btn-warning btn-xs" href="{{ url('member/investments/encode') }}">{{ Lang::get('codes.encode') }}</a>
                                    @endif
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
    </table>
</div>
{{ $codes->render() }}

<script src="/public/custom/js/jquery_scope.js">
</script>
<script>
    
    $.scoped();

    $(document).ready(function(){
       
        $(".btn-img").click(function(){
            var img_src = $(this).attr("data-src");
            $("#modal_image").on("shown.bs.modal", function () {
                $(".full_image").attr("src", img_src);
                $(this).appendTo("body");
            }).modal('show');
        })
    });
</script>

<!-- Modal -->
<div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Receipt Image</h4>
            </div>
            <div class="modal-body">
                <img class="full_image" style="width: 100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


