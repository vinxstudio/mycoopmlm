<div class="panel panel-theme rounded shadow">
    <div class="panel-heading">
        <div class="pull-left">
            <h3 class="panel-title">User Info<code></code></h3>
        </div>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
    </div><!-- /.panel-heading -->
    <div class="panel-body no-padding" style="display: block;">

        <div class="form-body">
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Account ID : </label>
                <div class="col-sm-3"><strong>{{ $user_info['accountid'] }}</strong></div>

                <label class="col-sm-3 control-label">Account Code</label>
                <div class="col-sm-3"><strong>{{ $user_info['code'] }}</strong> </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Fullname : </label>
                <div class="col-sm-3"><strong>{{ $user_info['fullname'] }}</strong></div>

                <label class="col-sm-3 control-label">Username : </label>
                <div class="col-sm-3"><strong>{{ $user_info['username'] }}</strong> </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Package : </label>
                <div class="col-sm-3"><strong>{{ $user_info['package'] }}</strong></div>
            </div>
            
        </div><!-- /.form-body -->

    </div><!-- /.panel-body -->
</div><!-- /.panel -->
<!--/ End inline form -->