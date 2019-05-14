@extends('layouts.master')
@section('content')

    @if(session()->has('transfer_success'))
    <div class="transfer-alert alert alert-success">
        {{ session('transfer_success') }}
    </div>
    @endif
    @foreach ($errors->all() as $error)
    <div class="transfer-alert alert alert-danger">
        {{ $error }}
    </div>
    @endforeach    

    @include('Admin.Products.views.purchase_code_form')

    <div class="pull-left box">
        <fieldset>
            <legend>Status</legend>

            {{-- Allocated to Branch Status --}}
            {{-- Commented --}}
            {{-- <div class="form-group display-block">
                <div class="col-sm-8">
                    <h5>
                        Allocated to Branch 
                    </h5>
                </div>
                <div class="col-sm-4">
                    <h5>
                        @if($old_filter_branch != '')
                            {{ $old_filter_branch }}
                        @else
                            All
                        @endif
                    </h5>
                </div>
            </div> --}}

            {{-- Product Status --}}
            <div class="row display-block">
                <div class="col-sm-6">
                    <h5>
                        Product 
                    </h5>
                </div>
                <div class="col-sm-6">
                    <h5>
                        @if($old_filter_product != '')
                            {{ $productsDropdown[$old_filter_product] }}
                        @else
                            All
                        @endif
                    </h5>
                </div>
            </div>
            <div class="row display-block">
                <div class="col-sm-6">
                    <h5>
                        Product Type
                    </h5>
                </div>
                <div class="col-sm-6">
                    <h5>
                        @if($old_filter_price_type != '')
                            {{ $price_type[$old_filter_price_type]  }}
                        @else
                            All
                        @endif
                    </h5>
                </div>
            </div>
            <div class="row display-block">
                <div class="col-sm-6">
                    <h5>
                        Total 
                    </h5>
                </div>
                <div class="col-sm-6">
                    <h5>
                        {{ count($codes) }}
                    </h5>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="clearfix"></div>

    <div class="hr-border"></div>

    {{-- Filter Options --}}
    <div class="pull-left box mt-10">
        <fieldset>
            <legend>Filter Options</legend>
            <form method="GET">
                <input type="hidden" name="filter_options" value="true" />
                <div class="pull-right form-group">
                    <h5>&nbsp;</h5>
                    <button class="filter-submit btn btn-md btn-primary">Submit</button> 
                </div>

                {{-- branches --}}
                {{-- Disabled Allocation --}}
                {{-- <div class="pull-right form-group">
                    <h5 class="display-block">
                        Allocated to Branch
                    </h5>
                    <select name="filter_branches" class="form-control">
                        <option hidden selected disabled value="-1">Please Select a Branch...</option>
                        <option value="0">All</option>
                        @foreach($branches as $branch)
                            @if(isset($old_filter_branch) && $branch->id == $old_filter_branch)
                                <option selected value="{{ $branch->id }}">{{ $branch->name }}</option> 
                            @else
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option> 
                             @endif
                        @endforeach
                    </select>
                </div> --}}
                
                {{-- product type --}}
                <div class="pull-right form-group">
                    <h5 class="display-block">
                        Product Type
                    </h5>  
                    <select name="filter_price_type" class="form-control">
                        <option selected value="0">All</option>
                        @foreach ($price_type as $price_key => $price_value)
                            @if(isset($old_filter_price_type) && $price_key == $old_filter_price_type)
                                <option selected value="{{ $price_key }}">{{ $price_value }}</option>
                            @else
                                <option value="{{ $price_key }}">{{ $price_value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                {{-- price type --}}
                <div class="pull-right form-group">
                    <h5 class="display-block">
                        Products
                    </h5>
                    <select name="filter_product" class="form-control">
                        <option selected value="0">All</option>
                        @foreach ($productsDropdown as $product_key => $product_value)
                            @if(isset($old_filter_product) && $product_key == $old_filter_product)
                                <option selected value="{{ $product_key }}">{{ $product_value }}</option>
                            @else
                                <option value="{{ $product_key }}">{{ $product_value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </form>
        </fieldset>
    </div>

    <div class="clearfix"></div>
    
    <div class="hr-border"></div>

    {{-- Transfer Options and Input --}}
    <div class="pull-left box mt-10">
        <fieldset>
            <legend>Transfer Options</legend>
            <p>Note: <i>If the amount of Transfer Number Codes exceed the Total Product Codes, All Total Product Codes will be transferred</i></p>
            <form action="/admin/products/transfer-products/" method="POST">
                {{-- Transfer Codes --}}
                <div class="pull-right form-group">
                    <h5>
                        Transfer Codes
                    </h5>
                    <div class="form-inline">
                        <input type="number" name="transfer_quantity" class="form-control" />
                        <button class="btn btn-md btn-primary">Submit</button>
                    </div>
                </div>
                {{-- branches --}}
                <div class="pull-right form-group">
                    <h5 class="display-block">
                        Branches
                    </h5>
                    <select name="transfer_branch" class="custom-select form-control">
                        <option hidden selected disabled value="0">Please Select a Branch...</option>
                        @foreach($branches as $branch)
                            <option @if($branch->id == $old_filter_branch) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option> 
                        @endforeach
                    </select>
                </div>
                {{-- product type --}}
                <div class="pull-right form-group">
                    <h5 class="display-block">
                        Product Type
                    </h5> 
                    <select name="transfer_price_type" class="form-control" disabled>
                        <option value="0">All</option>
                        @foreach ($price_type as $price_key => $price_value)
                            <option @if($old_filter_price_type == $price_key) selected @endif value="{{ $price_key }}">{{ $price_value }}</option>
                        @endforeach
                    </select>
                    @if($old_filter_price_type != '')
                        <input type="hidden" name="transfer_price_type" value="{{ $old_filter_price_type }}"/>
                    @endif
                </div>
                {{-- price type --}}
                <div class="pull-right form-group">
                    <h5 class="display-block">
                        Products
                    </h5>
                    <select name="transfer_product" class="form-control" disabled>
                        <option value="0">All</option>
                        @foreach ($productsDropdown as $product_key => $product_value)
                                <option @if($old_filter_product == $product_key) selected @endif value="{{ $product_key }}">{{ $product_value }}</option>
                        @endforeach
                    </select>
                    @if($old_filter_product != '')
                        <input type="hidden" name="transfer_product" value="{{ $old_filter_product }}"/>
                    @endif
                </div>
            </form>
        </fieldset>
    </div>
    <div class="clearfix"></div>
    <table class="table table-bordered table-stripe table-responsive-md">
        <thead>
            <tr>
                {{-- header of the table --}}
                <th>Barcode</th>
                <th>Product</th>
                <th>Code</th>
                <th>Password</th>
                <th>Created_By</th>
                <th>Created_At</th>
                <th>Status</th>
                {{-- Comment Single Transfer Branch --}}
                {{-- <th>Transfer to Branch</th> --}}
                {{--  --}}
                {{-- Multiple Transfer --}}
                {{-- <th>
                    <div class="check-box">
                        <input id="transfer-all" type="checkbox" name="transfer-all" />
                        <label for="transfer-all">All</label>
                    </div>
                </th> --}}
            </tr>
        </thead>
        <tbody>
            {{-- check number of items in array --}}
            @if (!count($codes) > 0)
                <tr>
                    <td colspan="7">
                        <center>
                            <i>You haven't generated any codes yet.</i>
                        </center>
                    </td>
                </tr>
            @else
            @foreach ($paginate as $code)
                    <tr>
                        {{-- Barcode Coloum --}}
                        <td class="col-md-2">
                            <div class="text-center">
                                <img src={{ $code['barcode_c93'] }} draggable="false" class="img-fluid" alt="Barcode" />
                            </div>
                        </td>
                        {{-- Product Id Coloumn --}}
                        <td class="col-md-1">{{ $productsDropdown[$code['product_id']].  '</br>----------</br>' . $code['product_type'] }}</td>
                       
                        {{-- Code Coloumn --}}
                        <td class="col-md-1">{{ $code['code'] }}</td>
                        
                        {{-- Password Coloumn --}}
                        <td class="col-md-1">{{ $code['password'] }}</td>
                        
                        {{-- Owner Name Coloumn --}}
                        <td class="col-md-2">{{ $code['generated_by'] }}</td>
                        
                        {{-- Date Created Coloumn  --}}
                        <td class="col-md-2">{{ date('F j, o. - h:i A', strtotime($code['created_at'])) }} </td>
                        
                        {{-- Status Coloumn --}}
                        {{-- Status 0 = available, bootstrap = bg-primary --}}
                        {{-- Status 1 = used, bootstrap = bg-warning --}}
                        {{-- Status 2 = transfered, bootstrap = bg-danger --}}
                        <td class='col-md-1'>
                            <div class="w-100 h-75 @if($code['status'] == 0) bg-primary @elseif($code['status'] == 1) bg-danger @elseif($code['status'] == 2) bg-success @endif" >
                                @if($code['status'] == 0)
                                    Available
                                @elseif($code['status'] == 1)
                                    Bought
                                @elseif($code['status'] == 2)
                                    Transferred
                                @endif
                            </div>
                        </td>

                        {{-- Action Bar Coloumn --}}
                        {{-- Drop Down List --}}
                        {{-- and --}}
                        {{-- Submit Button --}}
                        {{-- comment single transfer --}}
                        {{-- change to multiple transfer --}}
                        {{-- 
                        <td class='col-md-1'>
                            {{ Form2::open(['action' => 'Admin\\Products\\Codes\\GeneratedProductCodesContoller@branch', 'method' => 'post', 'class' => 'form-inline']) }}
                               <div class='col-sm-10'>
                                    {{-- 
                                        {{ Form2::select('branch', $branches->lists('name', 'id'), ['placeholder' => 'Pick a branch.....'], ['class' => 'form-control']) }}
                                    --}}
                                    {{-- check if branch id = default id --}}
                                    {{-- if default id disabled select --}}
                                    {{-- 
                                    @if($code['branch_id'] == 0)
                                        <select class='form-control' name='branch'>
                                    @else
                                        <select disabled class='form-control' name='branch'>
                                    @endif
                                        <option style='display:none' disabled selected value="0">Please select a Branch...</option>
                                        @foreach($branches as $branch)
                                            {{-- 0 id is the default id of dropdown list --}} 
                                            {{-- check if code branch id is == to default --}}
                                            {{--  
                                            {{-- check if the code branch id is == --}}
                                            {{-- the branch id --}}
                                            {{-- then display select this option --}}
                                            {{--
                                            @if($branch['id'] == $code['branch_id'])
                                                <option selected value={{ $branch['id'] }}>{{ $branch['name'] }}</option>
                                            @else
                                                {{-- add another option in the select --}}
                                            {{-- 
                                                <option value={{ $branch['id'] }}> {{ $branch['name'] }} </option>
                                            @endif
                                           
                                        @endforeach
                                    </select>
                                    
                               </div>
                                {{ Form2::hidden('unique_code', $code['code'])}}
                                {{-- check if branch id is default--}}
                                {{-- display if branch id is default --}}
                                {{--
                                @if($code['branch_id'] == 0)
                                    {{ Form2::submit('Submit', ['class' => 'btn btn-success']) }}
                                @endif
                            {{ Form2::close() }}
                        </td>
                        --}}
                        {{-- Multiple Transfer --}}
                        {{-- Checkbox --}}
                        {{-- <td class='col-md-1'>
                            <div class="check-box">
                                <input id="transfer" type="checkbox" name="transfer" />
                                <label for="transfer"></label>
                            </div>
                        </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $paginate->render() }}

    <script>

        $(document).ready(function(){

            setTimeout(function(){
                $('.transfer-alert').addClass('hide');
            }, 3000);

        //     $('.filter-submit').click(function(){

        //         let price_type = $('select[name="filter_product_type"]').val();
        //         let product_type = $('select[name="filter_product_type"]').val();
        //         let branch_type = $('select[name="filter_branches"]').val();

        //         let params = '';

        //         if(price_type != 0)
        //             params += ''

    
        //     });

        });
    
    </script>

    <style>

        /* display */
        
        .display-block{
             display: block !important;
         }

        .display-inline{
            display: inline;
        }
        .box{
            margin: 0;
        }
         
        .box > fieldset {
            padding: 15px;
        }
         .box > fieldset > legend {
            font-size: 16px;
            font-family: monospace;
        }

        form > .form-group{
            margin-right: 10px !important;
        }

        .mt-10{
            margin-top: 10px;
        }

        .hr-border{
            width: 100%;
            border-width: .50px;
            border-style: ridge;
            border-color: #2D6581;
        }
        
        /* status */
        

    </style>
    
@stop