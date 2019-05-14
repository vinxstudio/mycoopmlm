<?php $segment4 = Request::segment(4) ?>
<div class="col-md-12 col-xs-12 row">
    <div class="panel panel-theme rounded shadow">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">{{ Lang::get('products.add_unilevel') }}<code></code></h3>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body no-padding" style="display: block;">

            {{ Form::open([ 'class'=>'form-inline' ]) }}
            <div class="form-body">
                <div class="form-group">
                    {{ validationError($errors, 'amount') }}
                    <label class="col-sm-12 control-label">{{ Lang::get('pairing.amount') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="amount">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">{{ Lang::get('pairing.next_level') }}</label>
                    <div class="col-sm-12">
                        <label for="">{{ $nextLevel }}</label>
                    </div>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'quantity') }}
                    <label class="col-sm-12 control-label">{{ Lang::get('labels.type') }}</label>
                    <div class="col-sm-12">
                        {{ Form::select('type', [
                            'universal'=>Lang::get('products.universal'),
                            'per_product'=>Lang::get('products.per_product')
                        ], old('type', ($segment4 > 0) ? 'per_product' : ''), [
                            'class'=>'form-control chosen-select',
                            'id'=>'unilevel_type'
                        ]) }}
                    </div>
                </div>
                <div class="form-group hidden" id="product_list">
                    {{ validationError($errors, 'product') }}
                    <label class="col-sm-12 control-label">{{ Lang::get('labels.product') }}</label>
                    <div class="col-sm-12">
                        <select class="form-control chosen-select" name="product" id="product">
                            <option value="">{{ Lang::get('products.select_product') }}</option>
                            @foreach ($products as $product)
                                <option {{ ($segment4) > 0 ? 'selected="selected"' : null }} value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" name="add_unilevel" value="add_unilevel" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>

<div class="clearfix"></div>
<br/>