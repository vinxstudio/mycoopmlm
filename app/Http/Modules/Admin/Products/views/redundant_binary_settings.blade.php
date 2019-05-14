@extends('layouts.master')
@section('content')
    <div class="panel panel-theme rounded shadow">
        {{-- info notifications --}}
        <div class="alert @if(session('update_status')) {{ session('update_status') }} @else hide @endif" id="redundant_binary_info" role="alert">
            {{ session('update_message') }}
        </div>
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Redundant Binary Settings</h3>
            </div>
            <div class="clearfix"></div>
        </div>
        {{-- redundant binary points --}}
        {{-- points value --}}
        {{-- poinst equivalent --}}
        <div class="panel-body form-body" style="width: 100%;">
            {{ Form2::open(['url' => 'admin/products/redundant-binary-settings-update', 'method' => 'POST']) }}
                {{-- points value div --}}
                <div class="form-group" style="width: 15%; display: inline-block">
                    <label class="col-sm-12 control-label">Points Value</label>
                    <div class="col-md-10">
                        <input name="points_value" type="number" class="form-control" min="0" value="{{ $redundant_settings->points_value }}"/>
                    </div>
                </div>
                {{-- equals div--}}
                <div class="form-group" style="width: 5%; display: inline-block">
                    <div class="col-md-2">
                        <h4>=</h4>
                    </div>
                </div>
                {{-- points equavalent div --}}
                <div class="form-group" style="width: 15%; display: inline-block">
                    <label class="col-sm-12 control-label">Points Equivalent to Peso</label>
                    <div class="col-md-10">
                        <input name="points_equivalent" type="number" class="form-control" min="0" value="{{ $redundant_settings->points_equivalent }}"/>
                    </div>
                </div>
                <div class="form-group" style="width: 5%; display: inline-block">
                    <div class="col-md-2">
                        <h4>|</h4>
                    </div>
                </div>
                {{-- Redundant Binary Level --}}
                <div class="form-group" style="width: 15%; display: inline-block">
                    <label class="col-sm-12 control-lable">Up to nth level</label>
                    <div class="col-md-8">
                        <input name="redundant_binary_level" type="number" class="form-control" min="0" value="{{ $redundant_settings->up_to_level }}" />
                    </div>
                </div>
                {{-- submit button --}}
                <div class="form-group" style="width: 8%; display: inline-block">
                    <div class="col-md-5">
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-md']) }}
                        {{-- <button id="points-btn" type="button" class="btn btn-primary btn-md">Submit</button> --}}
                    </div>
                </div>
            {{ Form::close() }}
        </div>  
    </div>
    <table class="table text-dark">
        <thead>
            <tr>
                {{-- numbering --}}
                <th style="width: 3%;">
                </th>
                {{-- product image --}}
                <th style="width: 8%;">
                    Product
                </th>
                {{-- product name --}}
                <th style="width: 8%;">
                    Name
                </th>
                {{-- points --}}
                <th style="width: 15%;">
                    Points Per Product
                </th>
                <th style="width: 15%;">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            {{-- use @php @endphp with laravel 5.5 > --}}
            <?php 
                $product_no = 1;
            ?>
            @foreach ($products as $product)
            <tr>
                <td>
                    <div style="padding: 5px;">
                            {{ $product_no++ }}
                    </div>
                </td>
                <td>
                    <img src="{{ asset('public/products/' . $product->image)}}" alt="" class="img-thumbnail" style="width: 100%;"/>
                </td>
                <td>
                    <div class="text-dark" style="padding: 5px;">
                        <h4>
                            {{ $product->name }}
                        </h4>
                    </div>
                </td>
                <td>
                    <div class="form-group" style="padding: 5px;">
                        <input type="number" name="product_points_value" value="{{ $product->points_value == -1 ? 0 : $product->points_value }}" class="form-control product_points" @if($product->points_value == -1) disabled @endif data-points_value="{{ $product->points_value }}"/> 
                    </div>  
                </td>
                <td>
                    <div style="padding: 5px;">
                        <button class="btn btn-primary btn-md redundant_binary_update mb-5" type="button")>Update</button>
                        <button class="btn @if($product->points_value == -1) btn-success @else btn-danger @endif btn-md redundant_binary_endisabled mb-5 ml-10" type="button" data-type={{ $product->points_value }}>
                            @if($product->points_value == -1)
                                Enable
                            @else
                                Disabled
                            @endif
                        </button>
                        <input class="hidden_product_code" name="invinsible" type="hidden" value="{{ $product->id }}" />
                    </div>
                    <div class="alert hide alert_update">
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $products->render() }}
    </div>


    <script>
        
        $(document).ready(function(){

            // update points value of every product
            $(".redundant_binary_update").click(function(e){

                let input_points = $(this).closest('tr').find('input[name="product_points_value"]');

                let update_info = $(this).closest('td').find('.alert_update');

                let product_idx = $(this).siblings('.hidden_product_code').val();

                if(input_points.attr('data-points_value') != -1){

                    let data = {
                        product_id: product_idx,
                        points_value: input_points.val()
                    };

                    $.ajax({
                        url: '/admin/products/redundant-binary-update-product-points',
                        type: 'GET',
                        dataType: 'JSON',
                        data: data,
                        success: function(data){
                            ShowUpdateInfo(update_info, data.message, data.status);
                        },
                        error: function(data){
                            ShowUpdateInfo(update_info, data.responseJSON.message, data.responseJSON.status);
                        }

                    });

                }
                else{
                    ShowUpdateInfo(update_info, 'Unable to update points value', 'alert-danger');
                }

            });


            // Enabled and Disabled the product for redundant binary
            $('.redundant_binary_endisabled').click(function(){

                let btn = $(this);

                let btn_type = $(this).attr('data-type');

                let product_idx = $(this).siblings('.hidden_product_code').val();

                let input_points = $(this).closest('tr').find('input[name="product_points_value"]');

                let update_info = $(this).closest('td').find('.alert_update');

                if(btn_type != -1){
                    btn_type = 0;
                }

                console.log(product_idx);

                // if btn type is -1
                // product is disabled
                // this will send data to enable the product again
                // else 
                // btn type is not -1
                // send data to disable the product

                // for Enableing the product code

                $.ajax({
                    url: '/admin/products/en-disabled',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        product_id: product_idx,
                        type: btn_type
                    }
                }).done(function(data){
                    
                    console.log(data);
                    
                    input_points.val(0);

                    btn.removeClass('btn-success');
                    btn.removeClass('btn-danger');
                    btn.empty();

                    if(btn_type == -1){
                        
                        input_points.attr('disabled', false);

                        btn.addClass('btn-danger');

                        btn.empty().text('Disabled');

                        input_points.attr('data-points_value', 0);

                        btn.attr('data-type', 0);
                    }
                    else{                

                        input_points.attr('disabled', true);

                        btn.addClass('btn-success');

                        btn.empty().text('Enabled');

                        input_points.attr('data-points_value', -1);

                        btn.attr('data-type', -1);


                    }

                    ShowUpdateInfo(update_info, data.message, 'alert-success');


                }).fail(function(data){

                    console.log(data);
                    
                    ShowUpdateInfo(update_info, data.responseJSON.message, 'alert-danger');
                    

                });

        

            });

        });


        function ShowUpdateInfo(update, message, status)
        {
            let success = 'alert-success';
            let danger = 'alert-danger';

            update.removeClass(success);
            update.removeClass(danger);

            update.addClass(status);
            update.text(message);

            update.removeClass('hide'); 

            setTimeout(function (){
                update.addClass('hide');
            }, 3000);

        }
    
    </script>



@stop