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
            {{ Form::open(['class'=>'form-horizontal form-bordered', 'files' => true]) }}
                <input type="hidden" name="id" value="{{ old('id', isset($product->id)? $product->id: '') }}" />
                <div class="form-group">
                    {{ validationError($errors, 'image') }}
                    <div class="col-sm-3" style="text-align:right;">
                        @if(isset($product['image']))
                            <img class="col-right" width="60" src="{{ asset('public/products/'.$product->image) }}" alt="">
                        @endif
                    </div>
                    <label class="col-sm-1 control-label">image</label>
                    <div class="col-sm-7">
                        <input type="file" class="form-control" name="image" />
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'name') }}
                    <label class="col-sm-4 control-label">Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" value="{{ old('name', (isset($product->name)) ? $product->name : null) }}" name="name" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'slug') }}
                    <label class="col-sm-4 control-label">slug</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ old('slug', isset($product->slug)? $product->slug: '') }}" name="slug" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'price') }}
                    <label class="col-sm-4 control-label">SRP</label>
                    <div class="col-sm-4">
                        <input type="number" step="any" class="form-control" value="{{ old('price', isset($product->price)? $product->price: '') }}" name="price" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'rebates') }}
                    <label class="col-sm-4 control-label">Member's Price</label>
                    <div class="col-sm-1">
                        <input type="number" step="any" class="form-control" value="{{ old('rebates', isset($product->rebates)? $product->rebates: '') }}" id="rebatesPercentage" name="rebates" required="">
                    </div>
                    <label class="col-sm-4 control-label" id="rebatesCompute"></label>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'points_value') }}
                    <label class="col-sm-4 control-label">points_value</label>
                    <div class="col-sm-4">
                        <input type="number" step="any" class="form-control" value="{{ old('points_value', isset($product->points_value)? $product->points_value: '') }}" name="points_value" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'publish') }}
                    <label class="col-sm-4 control-label">Publish</label>
                    <div class="col-sm-12">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <input type="radio" class="form-control" name="publish" value="1" required="" checked>Yes</input>
                        </div>
                        <div class="col-sm-2">
                            <input type="radio" class="form-control" name="publish" value="0" required="" @if($product && $product->points_value === 0) checked @endif>No</input>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'type') }}
                    <label class="col-sm-4 control-label">Type</label>
                    @foreach($types as $key => $type)
                        <div class="col-sm-12">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-2">{{ $type }}</div>
                            <div class="col-sm-2">
                                <input type="radio" class="form-control" name="type" value="{{ $key }}" required="" @if($product && $product->type === $key) checked @endif />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'category') }}
                    <label class="col-sm-4 control-label">Category</label>
                    @foreach($categories as $key => $category)
                        <div class="col-sm-12">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-2">{{ $category }}</div>
                            <div class="col-sm-2">
                                <input type="radio" class="form-control" name="category" value="{{ $key }}" required="" @if($product && $product->category === $key) checked @endif />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'description') }}
                    <label class="col-sm-4 control-label">Description</label>
                    <div class="col-sm-7">
                        <textarea id="article-ckeditor" name="description" placeholder="Enter product description" required="">
                                {{ old('description', isset($product->description)? $product->description: '') }}
                        </textarea>
                    </div>
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
    <script src="{{url('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script>
            CKEDITOR.replace( 'article-ckeditor' );
    </script>
@stop