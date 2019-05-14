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
                        {{-- {{ validationError($errors, 'quantity') }} --}}
                        <label class="col-sm-12 control-label">Number of Codes</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="quantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            {{ validationError($errors, 'type') }}
                            <label class="col-sm-12 control-label">Product</label>
                            <div class="col-sm-12">
                                {{ Form::select('product', $productsDropdown, old('product'), ['class'=>'chosen-select']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Price Type</label>
                            <div class="col-sm-12">
                                {{ Form::select('price_type', $price_type, 'SRP', ['class'=>'chosen-select']) }}
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="generate-code" class="btn btn-success mt-10">{{ (Request::segment(1) == 'admin') ? 'Generate' : 'Buy' }} Codes</button>
                    {{-- Allocate to Branch --}}
                    {{-- Comment the branches in generate product code --}}
                    {{-- <div class="form-group" style="margin-top: 20px;">
                        {{ validationError($errors, 'generate_branches') }}
                        <label class="col-sm-12 control-label">Allocate to Branch</label>
                        <div class="col-sm-12">
                            <select name="generate_branches" class="form-control">
                                <option hidden disabled selected value="-1">Select a Branch...</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                </div><!-- /.form-body -->
                {{ Form::close() }}

            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
        <!--/ End inline form -->

    </div>
</div>
