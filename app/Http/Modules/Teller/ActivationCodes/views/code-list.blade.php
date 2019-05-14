@extends('layouts.master')
@section('content')

	@include('Admin.ActivationCodes.views.form')
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
        <input type="hidden" name="date_range" value="1">
        <div class='col-md-3'>
            <div class="form-group">
                <label>Date From</label>
                <div class='input-group date' id='from_date'>
                    <input type='text' name="date_from" class="form-control" value="{{ $date_from }}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-group">
                <label>Date To</label>
                <div class='input-group date' id='to_date'>
                    <input type='text' name="date_to" class="form-control" value="{{ $date_to }}" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-group">
                <label>&nbsp;</label>
                <div class='input-group date'>
                    <input type='submit' class="form-control btn btn-primary" value="SUBMIT"  />
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <?php
            $date_from = (!empty($date_from))? $date_from:'0';
            $date_to = (!empty($date_to))? $date_to:'0';
            ?>
            <div class="form-group">
                <label>&nbsp;</label>
                <div class='input-group'>
                    <a href="{{ url('admin/export-codes/xlsx/'.$date_from.'/'.$date_to)}}" class="form-control btn btn-success">Download Activation Code</a>
                </div>
            </div>
        </div>
    {{ Form::close() }}
     <?php
        $from = (!empty($date_from))? strtotime($date_from):'0';
        $to = (!empty($date_to))? strtotime($date_to):'0';
      ?> 
    <div class="col-md-12" id="codelist">
        {{ view('widgets.activationCodes.list')->with([
            'codes'=>$codes
        ])->render() }}
        {{ $codes->render() }}
    </div>
    @include('widgets.activationCodes.delete-modal')
    <script type="text/javascript">
        $(function() {
            $( "#from_date" ).datetimepicker({
                format:'YYYY-MM-DD 00:01:00',
            });
        });

        $(function() {
            $( "#to_date" ).datetimepicker({
                format:'YYYY-MM-DD 23:59:59',
            });
        });

        //view reason
        $(document).on('click','.btn-reason', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var reason_url = '/admin/activation-codes/reason/'+id;
           $.ajax({
            type : 'GET',
            url  : reason_url,
            success : function(data) {
                  if(data.errors)
                  {
                    $('#error_message').text(data.errors);
                  }
                  else {
                      $('#reason').val(data.reason);
                      $('.modal-footer').addClass('hidden');
                      $('#delete_modal').modal('show');
                  }
              }
          });
        });

        // delete function
        $(document).on('click','.btn-delete', function(e){
            e.preventDefault();
           $('#activation_id').val($(this).attr('data-id'));
           $('#delete_modal').modal('show');
        });
        
        var table_list = $('#codelist');
        $(document).on('click','#delete_submit',function(e){
           e.preventDefault();
           var form = $('#delete_form');
           var id = $('#activation_id').val();
           var delete_url = '/admin/activation-codes/delete-code/'+id;
           $.ajax({
            type : 'POST',
            url  : delete_url,
            data : form.serialize(),
            success : function(data) {
                  if(data.errors)
                  {
                    $('#error_message').text(data.errors);
                    $('#error_message').removeClass('hidden');
                  }
                  else {
                      $('#delete_modal').modal('hide');  
                      $( "#codelist" ).load( window.location.href+" #codelist" );
                  }
              }
          });
        });

        $(document).on('hidden.bs.modal','#delete_modal', function() {
            $('#delete_form')[0].reset();
            $('#error_message').addClass('hidden');
            $('.modal-footer').removeClass('hidden');
        });
    </script>
@stop
