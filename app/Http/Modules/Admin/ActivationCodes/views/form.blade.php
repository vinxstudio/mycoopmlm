<div class="row">
    <div class="col-md-12">

        <!-- Start inline form -->
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Generate New Codes<code></code></h3>
                </div>
                <div class="pull-right">
                    {{ makeBatchId() }}
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
                            {{ validationError($errors, 'quantity') }}
                            <label class="col-sm-12 control-label">Transfer To (username)</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="username" value="cpmpc_head">
                                <span id="error-msg"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'type') }}
                            <label class="col-sm-12 control-label">Code Type</label>
                            <div class="col-sm-12">
                                <select class="chosen-select" name="type" class="form-control" style="display: block;">
									@foreach($membership as $packages)
									<option value="{{ $packages->id }}">{{ $packages->membership_type_name }}</option>
									@endforeach
                                    <!--option value="free">Package B</option> 
									<option value="regular">Package C</option
                                    <!--option value="regular">Regular</option-->
									<!--<option value=CD">Commission Deductible</option>
                                    <option value="free">Free</option> -->
									
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="generate-code" class="btn btn-theme">Generate Codes</button>
                    </div><!-- /.form-body -->
                {{ Form::close() }}

            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
        <!--/ End inline form -->

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="username"]').on('change', function(){
            var thisusername = $('input[name="username"]').val();
            if(thisusername != ''){
                $.ajax({url: "<?php echo url('/') ?>/validateusername/"+thisusername, success:function(result){
                    console.log(result);
                    if (result != "Does not exist") {
                        name = result;
                        username = thisusername;
                        $('#error-msg').html('<label style="color:green;">'+ name +'</label>');
                        $('button[name="generate-code"]').attr('disabled', false);
                    }else{
                        $('button[name="generate-code"]').attr('disabled', true);
                        $('#error-msg').html('<label style="color:red;">Invalid Username</label>');
                    }
                }});
            }else{
                $('#error-msg').html('');
                $('button[name="generate-code"]').attr('disabled', false);
            }
            
        });
            
    });

</script>