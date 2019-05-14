<div class="row">
    <div class="col-md-12">

        <!-- Start inline form -->
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ (Request::segment(1) == 'admin') ? 'Generate' : 'Buy' }} New Purchase Codes<code></code></h3>
                </div>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div><!-- /.panel-heading -->
            <div class="panel-body no-padding" style="display: block;">

                {{ Form::open([ 'class'=>'form-inline' ]) }}
                <div class="form-body">
                    <div class="form-group">
                        {{ validationError($errors, 'quantity') }}
                        <label class="col-sm-12 control-label">Number of Codes</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="quantity">
                        </div>
                    </div>
                    <div class="form-group">
                        {{ validationError($errors, 'type') }}
                        <label class="col-sm-12 control-label">Product</label>
                        <div class="col-sm-12">
                            {{ Form::select('product', $productsDropdown, old('product'), ['class'=>'chosen-select']) }}
                        </div>
                    </div>
                    <button type="submit" name="generate-code" class="btn btn-success">{{ (Request::segment(1) == 'admin') ? 'Generate' : 'Buy' }} Codes</button>
                </div><!-- /.form-body -->
                {{ Form::close() }}

            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
        <!--/ End inline form -->

    </div>
</div>