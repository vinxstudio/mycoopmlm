<div class="row">
    <div class="col-md-12 pull-left">

        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('connection.set_passcode') }}<code></code></h3>
                </div>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div><!-- /.panel-heading -->
            <div class="panel-body" style="display: block;">

                {{ Form::open() }}

                    <div class="form-group">
                        {{ validationError($errors, 'quantity') }}
                        <label class="control-label">{{ Lang::get('connection.passcode') }}</label>
                        <br/>
                        <input type="text" class="form-control" value="{{ old('passcode', $company->passcode) }}" name="my_passcode">
                    </div>

                    <button type="submit" name="set_passcode" value="set_passcode" class="btn btn-success pull-left">{{ Lang::get('labels.save') }}</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>


    <div class="col-md-12 pull-left">

        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('connection.add_connection') }}<code></code></h3>
                </div>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div><!-- /.panel-heading -->
            <div class="panel-body" style="display: block;">

                {{ Form::open() }}
                    <p>{{ Lang::get('connection.description') }}</p>
                    <p>{{ Lang::get('connection.example') }}</p>
                    <p class="error-msg">{{ Lang::get('connection.url') }} : {{ Lang::get('connection.example_http') }}</p>
                    <p class="error-msg">{{ Lang::get('connection.passcode') }} : {{ Lang::get('connection.example_passcode') }}</p>
                    <div class="form-group">
                        {{ validationError($errors, 'url') }}
                        <label class="control-label">{{ Lang::get('connection.url') }}</label>
                        <input type="text" class="form-control" value="{{ old('url') }}" name="url">
                    </div>
                    <div class="form-group">
                        {{ validationError($errors, 'passcode') }}
                        <label class="control-label">{{ Lang::get('connection.passcode') }}</label>
                        <input type="text" class="form-control" value="{{ old('url') }}" name="passcode">
                    </div>

                    <button type="submit" name="add_connection" value="add_connection" class="btn btn-success pull-right">{{ Lang::get('labels.save') }}</button>

                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>