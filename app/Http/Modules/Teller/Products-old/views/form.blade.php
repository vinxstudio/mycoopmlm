@extends('layouts.master')
@section('content')
    <a href="{{ url('admin/products') }}" class="btn btn-link"><i class="fa fa-arrow-left"></i> back</a>

    <div class="panel panel-primary rounded shadow mt-15">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Manage Product</h3>
            </div>

            <div class="clearfix"></div>
        </div><!-- /.panel-heading  -->
        <div class="panel-sub-heading">
            <div class="callout callout-info"><p>Add or Update your products here.</p></div>
        </div><!-- /.panel-sub-heading  -->
        <div class="panel-body no-padding">
            {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
                <div class="form-group">
                    {{ validationError($errors, 'productName') }}
                    <label class="col-sm-4 control-label">Product Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" value="{{ old('productName', (isset($product->name)) ? $product->name : null) }}" name="productName">
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'price') }}
                    <label class="col-sm-4 control-label">Price</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('price', (isset($product->price)) ? $product->price : null) }}" id="productPrice" name="price">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Product Description</label>
                    <div class="col-sm-7">
                        <textarea id="article-ckeditor" name="productDescription" placeholder="Enter product description">
                                {{ old('product_description', (isset($product->product_description)) ? $product->product_description : null) }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'globalPoolPercentage') }}
                    <label class="col-sm-4 control-label">Percentage that will go to Global Pool</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control pull-left" id="globalPoolPercentage" disabled="true" value="{{ old('globalPoolPercentage', (isset($product->global_pool)) ? $product->global_pool : null) }}" name="globalPoolPercentage">
                    </div>
                    <span class="pull-left">%</span>
                    <label class="col-sm-4 control-label" id="globalPoolCompute"></label>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'rebatesPercentage') }}
                    <label class="col-sm-4 control-label">Rebates when members bought</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="rebatesPercentage" disabled="true" value="{{ old('rebatesPercentage', (isset($product->rebates)) ? $product->rebates : null) }}" name="rebatesPercentage">
                    </div>
                    <span class="pull-left">%</span>
                    <label class="col-sm-4 control-label" id="rebatesCompute"></label>

                </div>
                <div class="form-group">
                    {{ Form::button('Save', [
                        'type'=>'submit',
                        'name'=>'save',
                        'value'=>'save',
                        'class'=>'btn btn-success pull-right mr-20'
                    ]) }}
                </div>

            {{ Form::close() }}
        </div><!-- /.panel-body  -->
    </div>
@stop

@section('custom_includes')
    {{ Html::script('public/custom/js/products.js') }}
    <script src="{{url('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script>
            CKEDITOR.replace( 'article-ckeditor' );
    </script>
@stop