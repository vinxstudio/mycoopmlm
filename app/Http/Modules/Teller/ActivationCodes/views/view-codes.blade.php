@extends('layouts.teller')
@section('content')
    <a href="{{ url('teller/activation-codes') }}" class="btn btn-link"><i class="fa fa-arrow-left"></i> back</a>
    <br/>

    <?php
    set_time_limit(3000);

    $new_from_date = date("F d, Y", strtotime($date_from));
    $new_to_date = date("F d, Y", strtotime($date_to));

    ?>
   <div class='col-md-12'>
        <div class="col-md-4">
          <h2>Monthly Generated Code</h2>
          <h4>From : {{ $new_from_date }} To : {{ $new_to_date }}</h4> 
        </div>
    </div>
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
        <div class='col-md-6'>
          <div class="pull-left" style="margin-top: 40px;">
            <div class="pull-left">
            
              <?php $selected = $date_from.'_'.$date_to; ?>
              {{ 
                Form::select('month',$month_range, $selected, [
                            'class'=>'form-control'] ) 
              }}
            </div>
            <div class="pull-left">
              <span><button type="submit" class="btn btn-success"> Submit </button></span>
            </div>
          </div>
        </div>
        <div class='col-md-6'>
              <div class="form-group pull-right">
                <label>&nbsp;</label>
                  <div class='input-group date'>
                   <?php
                    $date_from = (!empty($date_from))? $date_from:'0';
                    $date_to = (!empty($date_to))? $date_to:'0';
                    $username = (!empty($username))? $username:'0';
                    ?>
                      <a href="{{ url('teller/export-codes/xlsx/'.$username.'/'.$date_from.'/'.$date_to)}}" class="form-control btn btn-success">Download Activation Code</a>
                  </div>
              </div>
        </div>
      {{ Form::close() }}   
    <?php

    $from = (!empty($date_from))? strtotime($date_from):'0';
    $to = (!empty($date_to))? strtotime($date_to):'0';
    ?>
    <div class="col-md-12"  id="codelist">
        {{ view('widgets.activationCodes.list')->with([
            'codes'=>$codes
        ])}}
    </div>
    
	@include('widgets.activationCodes.delete-modal')
    <script>
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
        $(document).ready(function(){
            $('#activation_table').DataTable({
                ordering: false,
                searching: true,
                paging : false,
                lengthChange: false,
                info : false,
                responsive: false
            });
        });
        $(document).on('click','.btn-reason', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var reason_url = '/teller/activation-codes/reason/'+id;
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
           var delete_url = '/teller/activation-codes/delete-code/'+id;
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
                      //$( "#codelist" ).load( window.location.href+" #codelist" );
                      location.reload();
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
