@extends('layouts.teller')
@section('content')
<style>
    .font-weight-bold{
        font-weight: bold;
    }

    .p-2{
        padding: 5px;
    }
    .m-0{
        margin: 0px;
    }

    .mb-2px{
        margin-bottom: 2px;
    }

    .form-control{
        display: inline-block;
        width: auto;
    }

    .form-max{
        display: block !important;
        width: 100% !important;
    }

    .form-group{
        width: auto;
        display: inline-block;
    }

    .w-100px{
        width: 100px;   
    }

    .w-200px{
        width: 200px;   
    }

</style>

<div class='col-md-4'>
    <span>
        <h2>Product Codes</h2>
    </span>
</div>
{{-- Total of all product codes --}}
<div class='col-md-4 mt-5 @if($product_slug_name != "") pull-right @else pull-left @endif font-weight-bold'>
    {{-- bought codes --}}
    <div class="pull-right mr-5 ml-5">
    <h5 class="font-weight-bold">
            <kbd class="p-2">
                Bought Codes
            </kbd>
        </h5>
        <span class="badge badge-danger">
            @if($product_slug_name == "")
                @foreach ($total_product_codes as $codes)
                    @if($codes['status'] == 1)
                        <?php 
                            $bought_count = $codes->product_codes;
                        ?>
                    @endif
                @endforeach
                {{ isset($bought_count) ? $bought_count : 0 }}
            @else   
                {{ $total_product_codes->bought }}
            @endif
        </span>
    </div>
    {{-- available codes --}}
    <div class="pull-right mr-5 ml-5">
        <h5 class="font-weight-bold">
            <kbd class="p-2">
                Available Codes
            </kbd>
        </h5>
        <span class="badge badge-success">
            @if($product_slug_name == "")
                @foreach ($total_product_codes as $codes)
                    @if($codes['status'] == 2)
                        <?php 
                            $ava_count = $codes->product_codes;
                        ?>
                    @endif  
                @endforeach
                {{ isset($ava_count) ? $ava_count : 0 }}
            @else
                {{ $total_product_codes->available }}
            @endif
        </span>
    </div>
    <div class="pull-right mr-5 ml-5">
        <h5 class="font-weight-bold">
            <kbd class="p-2">
                Total Product Codes
            </kbd>
        </h5>
        <span class="badge badge-primary">
            @if($product_slug_name == "")
                {{ $total_product_codes->sum('product_codes') }}
            @else
                {{ $total_product_codes->total }}
            @endif
        </span>
    </div>
</div>

{{-- Total per product of bought and used --}}
@if($product_slug_name == "")
    <div class='col-md-4 mt-5 pull-right font-weight-bold'>
        @foreach ($total_per_products as $codes)        
            <div class="pull-left mr-20 ml-5 mb-10 w-100px">
                <h5 class="font-weight-bold">
                    <kbd class="p-2">
                        {{ $codes->name }}
                    </kbd>
                </h5>
                {{-- Total --}}
                <div class="m-0 badge badge-primary ">
                    {{ $codes->total }}
                </div>
                {{-- Available --}}
                <div class="m-0 badge badge-success">
                    {{ $codes->available }}
                </div>
                {{-- Used --}}
                <div class="m-0 badge badge-danger ">
                    {{ $codes->bought }}
                </div>
            </div>
        @endforeach
    </div>

@endif

<div class="clearfix"></div>

<table class="table table-bordered table-striped">
    {{-- table head --}}
    <thead>
        {{-- barcode coloumn --}}
        <th>Barcode</th>
        {{-- product name coloumn --}}
        <th>Product</th>
        {{-- code coloumn coloumn --}}
        <th>Code</th>
        {{-- created by coloumn --}}
        <th>Created By</th>
        {{-- created at coloumn --}}
        <th>Created At</th>
        {{-- status coloumn --}}
        {{-- default status received at --}}
        <th>Status</th>
        {{-- transfer date at coloum --}}
        <th>Received On</th>
        {{-- Bought By --}}
        <th>Bought By</th>
        {{-- Transfer to another branch --}}
        <th>Transfer Branch</th>
    </thead>
    {{-- table body --}}
    <tbody>
        {{-- loop the product_codes --}}
            @foreach($product_codes as $code)
                <tr>
                    {{-- show barcode --}}
                    <td class="col-md-2">
                        <div class="text-center">
                                <img src={{ $code['barcode_c93'] }} draggable="false" class="img-fluid" alt="Barcode" />
                        </div>
                    </td>
                    {{--  show the product name --}}
                    <td class='col-md-1'>
                        {{ $code['name'] . '</br>---------</br>' . $code['product_type'] }}
                    </td>
                    {{-- display the product code --}}
                    <td class='col-md-1'>
                        {{ $code['code'] }}
                    </td>
                    {{-- display the one who generate the product --}}
                    <td class='col-md-1'>
                        @if($code['generated_username'])
                            {{ $code['generated_username'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    {{-- display the date created at --}}
                    {{-- Format : Month day, Year. - hour:min --}}
                    <td class="col-md-2">
                        {{ date('F j, o. - h:i A', strtotime($code['created_at'])) }}
                    </td>

                    {{-- Status Coloumn --}}
                    {{-- Status 0 = available, bootstrap = bg-primary --}}
                    {{-- Status 1 = used, bootstrap = bg-warning --}}
                    {{-- Status 2 = transfered, bootstrap = bg-danger --}}
                    <td class='col-md-1'>
                            <div class="w-100 h-75 @if($code['status'] == 0 || $code['status'] == 3) bg-primary @elseif($code['status'] == 1) bg-danger @elseif($code['status'] == 2) bg-success @endif" >
                                @if($code['status'] == 0)
                                    Available
                                @elseif($code['status'] == 1)
                                    Bought
                                @elseif($code['status'] == 2)
                                    Transferred
                                @elseif($code['status'] == 3)
                                    Activated
                                @endif
                            </div>
                    </td>
                    {{-- display received date --}}
                    <td class='col-md-2'>
                        {{ date('F j, o. - h:i A', strtotime($code['transfered_on'])) }}
                    </td>
                    {{-- display name of who bought --}}
                    <td class='col-md-2'>
                        @if($code['owner_username'])
                            {{ $code['owner_username'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="col-md-10">
                        <button class="btn btn-primary btn-sm transfer" @if($code->status != 1 || $code->status != 3) disabled @endif data-toggle="modal" data-target="#modal" data-codeId="{{ $code->id }}" data-currentBranch={{ $code->branch_id }} >Transfer</button>
                    </td>
                </tr>
            @endforeach
            {{-- render the pagination --}}
            {{ $product_codes->appends(Input::except('page'))->render() }}

            <div class="form-group pull-right mr-10" style="margin-top: 20px">
                
                <div class="pull-left mr-10">
                    <div class="form-group w-200px mr-10"> 
                        <div class='input-group date' id='datefrom'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group w-200px mr-10"> 
                        <div class='input-group date' id='dateto'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary pull-right mr-10" id="date_submit">Submit</button>
                </div>

                {{-- Select Option for Bought or Available --}}
                <select class="form-control select" data-select="product_availability">
                    <option value="All">All</option>
                    <option value="available" @if($product_availability == 'available') selected @endif>Available</option>
                    <option value="bought" @if($product_availability == 'bought') selected @endif>Bought</option>
                </select>
                
                {{-- Select Option for Product list --}}
                <select class="form-control select" id="product_select" data-select="product_name">
                    {{-- default option --}}
                    <option selected value="-1" disabled style="display:none;">Product</option>
                    {{-- all of products --}}
                    <option value="All">All</option>
                    {{-- loop product list --}}
                    @foreach ($product_list as $product)
                        <option @if($product_slug_name == $product->slug) selected @endif value="{{ $product->slug }}">{{ $product->name }}</option>
                    @endforeach
                </select>

            </div>

    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content aws">
            <div class="modal-header">
                <div class="alert hide">

                </div>
                <h4 class="modal-title" id="modal-title">
                    Select Branch 
                </h4>
            </div>
            <div class="modal-body" id="modal-message">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-confirm">Transfer</button>
            </div>
        </div>
    </div>
</div>  

<script>
    
    var product_name = {{ json_encode($product_slug_name) }};
    var product_availability = {{ json_encode($product_availability) }};

    var date_from = {{ json_encode($date_from) }};
    var date_to = {{ json_encode($date_to) }};

    var branches = {{ json_encode($branches) }};

    var dateNow = new Date();

    // if date from have no value
    if(date_from == '')
        date_from = '2018/12/01';
    // if date to have no value
    if(date_to == '')
        date_to = dateNow;

    // global modal variable
    var modale = $('#modal');
    // variable for who's td is transfer is click
    var tableRow = '';

    var modalTitle = modale.find('#modal-label');
    var modalMessage = modale.find('#modal-message');

    $(document).ready(function(){

        // date time picker

        modale.appendTo('body');

        $( "#datefrom" ).datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: date_from
        });
        $( "#dateto" ).datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false,
            defaultDate: date_to
        });

        $("#datefrom").on("dp.change", function (e) {
            $('#dateto').data("DateTimePicker").minDate(e.date);
        });

        $("#dateto").on("dp.change", function (e) {
            $('#datefrom').data("DateTimePicker").maxDate(e.date);
        });

        
        // when select product is change
        $('.select').change(function(e){
            
            let params = '';
            let select_type = $(this).attr('data-select');

            // select types
            let pro = 'product_name';
            let ava = 'product_availability';
            // if product name have no value and the select select type is not product name
            if(product_name != '' && select_type != pro)
                params += 'product_name=' + product_name + '&';
            // if availability have no value and select type not availability
            if(product_availability != '' && select_type != ava)
                params += 'product_availability=' + product_availability + '&';
            // if date_from have no value
            if(date_from != '')
                params += 'date_from=' + date_from + '&';
            // if date to have no value
            if(date_to != '')
                params += 'date_to=' + date_to + '&'; 
            // if value is not all
            if(select_type == pro && e.target.value != 'All')
                params += pro +'=' + e.target.value + '&';
            if(select_type == ava && e.target.value != 'All')
                params += ava + '=' + e.target.value + '&';

            // remove character ( & ) in the params string
            params = params.slice(0, -1);
            

            location.href = location.protocol + '//' + location.host + location.pathname + '?' + params;
            
        });

        // On Submit Date Click
        $('#date_submit').click(function(e){

            let dat_from = $('#datefrom').data().date;
            let dat_to = $('#dateto').data().date;

            let params = '';

            if(product_name != '')
                params += 'product_name=' + product_name + '&';
            if(product_availability != '')
                params += 'product_availability=' + product_availability + '&';

            params += 'date_from=' + dat_from + '&'; 

            params += 'date_to=' + dat_to + '&';
 
            params = params.slice(0, -1);

            location.href = location.protocol + '//' + location.host + location.pathname + '?' + params;

        });

        // when transfer button is click
        $('.transfer').click(function(){
            //  get branch id
            //  get code id
            let branchId = $(this).attr('data-currentBranch');
            let codeId = $(this).attr('data-codeId');

            let message = SelectInput(branches, branchId, codeId);

            tableRow = $(this).closest('tr');

            modalMessage.empty();
            
            // empty modale
            modalMessage.append(message);    
        });

        // when modal transfer button is click
        $('#modal-confirm').click(function(){

            let parentContent = $(this).closest('.modal-content');

            let branchId = parentContent.find('select[name="transfer_branch"]').val();
            let codeId = parentContent.find('input:hidden[name="code_id"]').val();

            let info = parentContent.find('.alert');

            let confirmBtn = $(this);

            confirmBtn.attr('disabled', true);

            console.log(tableRow);

            $.ajax({
                url: '/teller/product-codes/transfer-branch/',
                method: 'POST',
                dataType: 'JSON',
                data: { 
                    branchId : branchId,
                    codeId : codeId
                }
            }).done(function(data){
                
                info.addClass('alert-success');
                info.removeClass('hide');
                info.text(data.message);

                setTimeout(function(){ 

                    info.removeClass('alert-success');
                    info.addClass('hide');

                    modale.modal('hide');

                    tableRow.remove();

                }, 2000);

                confirmBtn.removeAttr('disabled');

                console.log(data);

            }).fail(function(data){
                
                info.removeClass('hide');
                info.addClass('alert-danger');
                info.text(data.responseJSON.message);

                setTimeout(function(){ 

                    info.removeClass('alert-danger');
                    info.addClass('hide');

                }, 2000);

                confirmBtn.removeAttr('disabled');

                console.log(data);

            });

        });
        

    });

    function SelectInput(branches, branchId, codeId){

        // Select for branches
        // input type hidden for code id
         
        let select = '<select class="form-control form-max" name="transfer_branch">' +
                    '<option disabled selected value="-1" style="display: none">' +
                        'Select Branch...' +
                    '</option>';
        // loop branches and add to select as option
        branches.forEach(branch => {
            // if the same branch id make is selected
            // and continue to next iteration
            if(branchId == branch['id']){
                select += '<option selected value="' + branch['id'] + '">' +
                            branch['name'] +
                        '</option>';
                return;
            }

            select += '<option value="' + branch['id'] + '">' +
                        branch['name'] +
                    '</option>';
        });    
        // closing tag select
        // input hidden for code id
        select += '</select>' +
                '<input type="hidden" name="code_id" value="' + codeId +'"/>';

        return select;
    }

</script>

@stop
