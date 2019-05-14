@extends('layouts.master')
@section('content')
<style>
    .p-10px{
        padding: 10px;
    }

    .p-5px{
        padding: 5px;
    }

    .w-100px{
        width: 100px;
    }

    .form-control{
        display: inline-block;
        width: auto;
    }

    .form-group{
        width: auto;
        display: inline-block;
    }

    .w-200px{
        width: 200px;   
    }

    .text-ellip{
        display: inline-block;
        width: 80px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>

<div class="panel panel-theme rounded shadow">
    <div class="panel-heading">
        <div class="pull-left">
                <h3 class="panel-title">Product Codes Inventory</h3>
            </div>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
    </div><!-- /.panel-heading -->
    <div class="panel-body no-padding">
        <div class='col-md-8 mt-5 ml-0 font-weight-bold mb-10'>
            {{-- total --}}
            <div class="pull-left mr-5 ml-5">
                <h5 class="font-weight-bold">
                    <kbd class="p-10px">
                        Total Product Codes
                    </kbd>
                </h5>
                <span class="badge badge-primary">
                    {{ $total_product_all->sum('total') }}
                </span>
            </div>
            {{-- unstransferred available --}}
            <div class="pull-left mr-5 ml-5">
                <h5 class="font-weight-bold">
                    <kbd class="p-10px">
                        Untransferred Available Codes
                    </kbd>
                </h5>
                <span class="badge badge-success">
                    @foreach ($total_product_all as $product)
                        @if($product->status == 0)
                            {{ $un_ava_total = $product->total }}
                        @endif
                    @endforeach
                    {{ isset($un_ava_total) ? '' : 0 }}
                </span>
            </div>
            {{-- transferred available --}}
            <div class="pull-left mr-5 ml-5">
                <h5 class="font-weight-bold">
                    <kbd class="p-10px">
                        Transferred Available Codes
                    </kbd>
                </h5>
                <span class="badge badge-success">
                    @foreach ($total_product_all as $product)
                        @if($product->status == 2)
                            {{ $ava_total = $product->total }}
                        @endif
                    @endforeach
                    {{ isset($ava_total) ? '' : 0 }}
                </span>
            </div>
            {{-- bought codes --}}
            <div class="pull-left mr-5 ml-5">
                <h5 class="font-weight-bold">
                    <kbd class="p-10px">
                        Bought Codes
                    </kbd>
                </h5>
                <span class="badge badge-danger">
                    @foreach ($total_product_all as $product)
                        @if($product->status == 1)
                            {{ $bought_total = $product->total }}
                        @endif
                    @endforeach
                    {{ isset($bought_total) ? '' : 0 }}
                </span>
            </div>
            
            {{-- per products --}}
            <div class='mt-30 pull-left font-weight-bold col-md-12'>
                @if(!$total_product_per->isEmpty())
                    @foreach ($total_product_per as $product)
                        <div class="pull-left mr-10 mb-10 w-100px">
                            <h5 class="font-weight-bold mb-5">
                                <kbd class="p-5px">
                                    <span class="text-ellip">{{ $product->name }}</span>
                                </kbd>
                            </h5>
                            {{-- Total --}}
                            <div class="m-0 badge badge-primary">
                                {{ $product->total }}
                            </div>
                            {{-- Available --}}
                            <div class="m-0 badge badge-success">
                                {{ $product->untransferred_available }}
                            </div>
                            <div class="m-0 badge badge-success">
                                {{ $product->transferred_available }}
                            </div>
                            {{-- Used --}}
                            <div class="m-0 badge badge-danger">
                                {{ $product->bought }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

            
        {{--  --}}
        <div class="mt-10 mr-20 pull-right">
            <fieldset>
                <legend>Legend</legend>
                <div class="row">
                    <div class="col-md-12">
                        <span class="display-block">
                            <span>
                                Total
                            </span>
                            <span class="bg-primary">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                        </span>
                        <span class="display-block">
                            <span>
                                Available
                            </span>
                            <span class="bg-success unstrans">
                                <span>
                                    Uns / Trans
                                </span>
                            </span>
                        </span>
                        <span class="display-block">
                            <span>
                                Bought
                            </span>
                            <span class="bg-danger">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                        </span>
                        <span class="display-block font-bold">
                            <br/>
                            Unstransferred / Transferred
                        </span>
                    </div>
                </div>
            </fieldset>
        </div>

    </div><!-- /.panel-body -->
</div><!-- /.panel -->
<!--/ End inline form -->

<div class="clearfix"></div>


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
    
            <button class="btn btn-primary pull-right mr-10" id="date_submit">Submit</button>
    
        </div>
    
        {{-- Select Option for Bought or Available --}}
        <select class="form-control select" data-select="product_availability">
            <option selected disabled value="-1" style="display: none;">Availability</option>
            <option value="All">All</option>
            <option @if($product_availability == 'untransferred') selected @endif value="untransferred">Untransferred</option>
            <option @if($product_availability == 'available') selected @endif value="available">Available</option>
            <option @if($product_availability == 'bought') selected @endif value="bought">Bought</option>
        </select>
        
        {{-- Select Option for Product list --}}
        <select class="form-control select" id="product_select" data-select="product_name">
            {{-- default option --}}
            <option selected value="-1" disabled style="display:none;">Product</option>
            {{-- all of products --}}
            <option value="All">All</option>
            {{-- loop product list --}}
            @foreach ($products as $product)
                <option @if($product_name == $product->slug) selected @endif value="{{ $product->slug }}">{{ $product->name }}</option>
            @endforeach
        </select>

        {{-- Select Option for Branches --}}
        <select class="form-control select" data-select="branch_no">
            <option selected value="-1" disabled style="display: none;">Branch</option>
            <option value="All">All</option>
            @foreach ($branches as $branch)
                <option @if($coop_branch == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
    
    </div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="col-md-1">
                Product
            </th>
            <th class="col-md-2">
                Code
            </th>
            <th class="col-md-1">
                Created By
            </th>
            <th class="col-md-1">
                Created At
            </th>
            <th class="col-md-1">
                Status
            </th>
            <th class="col-md-1">
                Bought
            </th>
            <th class="col-md-2">
                Branch
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product_codes as $item)
            <tr>
                {{-- product --}}
                <td>
                    {{ $item->product_name . '</br>---------</br>' . $item->product_type }}
                </td>
                {{-- code --}}
                <td>
                    {{ $item->code }}
                </td>
                {{-- created by --}}
                <td>
                    {{ $item->generated_name }}
                </td>
                {{-- created at --}}
                <td>
                    {{ date('F d, Y', strtotime($item->date_created)) }}
                </td>
                {{-- status --}}
                <td>
                    <div class="w-100 h-75 @if($item['status'] == 0) bg-primary @elseif($item['status'] == 1) bg-danger @elseif($item['status'] == 2) bg-success @endif" >
                        @if($item['status'] == 0)
                            Untrans-Available
                        @elseif($item['status'] == 1)
                            Bought
                        @elseif($item['status'] == 2)
                            Trans-Available
                        @endif
                    </div>
                </td>
                {{-- bought --}}
                <td>
                    @if($item['owner_name'])
                        {{ $item['owner_name'] }}
                    @else
                        N/A
                    @endif
                </td>
                {{-- branch --}}
                <td>
                    @if($item['branch_name'])
                        {{ $item['branch_name'] }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $product_codes->appends(Input::except('page'))->render() }}

<script>

        var product_name = {{ json_encode($product_name) }};
        var product_availability = {{ json_encode($product_availability) }};
        var coop_branch = {{ json_encode($coop_branch) }};
        var date_from = {{ json_encode($date_from) }};
        var date_to = {{ json_encode($date_to) }};

        var isDate = {{json_encode($is_date) }};

        $(document).ready(function(){

            // Date
            $( "#datefrom" ).datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: date_from
            });
            $( "#dateto" ).datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: date_to,
                useCurrent: false
            });

            $("#datefrom").on("dp.change", function (e) {
                $('#dateto').data("DateTimePicker").minDate(e.date);
            });

            $("#dateto").on("dp.change", function (e) {
                $('#datefrom').data("DateTimePicker").maxDate(e.date);
            });

            $('.select').change(function(e){

                let params = '';
                let type = $(this).attr('data-select');

                let ava = 'product_availability';
                let pro = 'product_name';
                let branch = 'branch_no';

                if(product_name != '' && type != pro)
                    params += 'product_name=' + product_name + '&';
                if(product_availability != '' && type != ava)
                    params += 'product_availability=' + product_availability + '&';
                if(coop_branch != '' && type != branch)
                    params += 'branch_no=' + coop_branch + '&';
                
                if(isDate)
                    params += 'date_from=' + date_from + '&' + 'date_to=' + date_to + '&';
                
                if(e.target.value != 'All')
                    params += type + '=' + e.target.value + '&';
                    
                params = params.slice(0, -1);
 
                location.href = location.protocol + '//' + location.host + location.pathname + '?' + params;
            });

            
        $('#date_submit').click(function(e){

            let dat_from = $('#datefrom').data().date;
            let dat_to = $('#dateto').data().date;

            let params = '';

            if(product_name != '')
                params += 'product_name=' + product_name + '&';
            if(product_availability != '')
                params += 'product_availability=' + product_availability + '&';
            if(coop_branch != '')
                params += 'branch_no=' + coop_branch + '&';

            params += 'date_from=' + dat_from + '&'; 

            params += 'date_to=' + dat_to + '&';

            params = params.slice(0, -1);

            location.href = location.protocol + '//' + location.host + location.pathname + '?' + params;

            });


        });


</script>

<style>

    fieldset > legend{
        font-size: 18px;
    }

    .display-block{
        display: block;
        position: relative;
        width: 100%;
    }

    .display-block span:first-child{
        position: inherit;
        display: inline-block;
        width: 75px;
    }
    .display-block span{
        font-weight: bold;
        font-size: 1em;
    }

    .display-block span.unstrans > span{
        font-size: .85em;
        width: 72px;
        position: relative;
    }


    .font-bold{
        font-weight: bold;
    }

</style>

@stop