@extends('layouts.master')
@section('content')

    @if($theUser->role_type != 'accounting')
        @include('Admin.ActivationCodes.views.form')
    @endif
    <?php
    set_time_limit(3000);

    $new_from_date = date("F d, Y", strtotime($date_from));
    $new_to_date = date("F d, Y", strtotime($date_to));

    $filter_date = (($filter == 'date-range')) ? '' : 'hidden';
    $filter_monthly = (($filter == 'monthly')) ? '' : 'hidden';
    $filter_activation_name = (!empty($filter) && $filter != 'date-range' && $filter != 'monthly') ? '' : 'hidden';

    ?>
   <div class='col-md-12 form-group'>
        <div class="col-md-4">
          <h2>Generated Code</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <select class="form-control" id="filter-by" place-holder="Filter By">
                    <option disabled selected>Filter By..</option>
                    <option value="date_range" {{($filter == 'date-range') ? 'selected' : ''}}>Date Range</option>
                    <option value="monthly" {{($filter == 'monthly') ? 'selected' : ''}}>Monthly</option>
                    <option value="activation_name" {{ !empty($filter) && $filter  != 'date-range' && $filter != 'monthly' ? 'selected' : '' }}>Activation Code</option>
                </select>
            </div>
            <div class="col-md-3 col-md-offset-7 form-group">
                <?php
                    $date_from = (!empty($date_from))? $date_from:'0';
                    $date_to = (!empty($date_to))? $date_to:'0';
                ?>
                <a href="{{ url('admin/export-codes/xlsx/'.$date_from.'/'.$date_to)}}" class="btn btn-success pull-right"><i class="fas fa-download"></i> Download Activation Code</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            {{ Form::open(['class'=>'form-horizontal form-bordered date-range '.$filter_date]) }}
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
            {{ Form::close() }}
            {{ Form::open(['class'=>'form-inline form-bordered monthly '.$filter_monthly]) }}
                <div class="col-md-3">
                    <?php $selected = $date_from.'_'.$date_to; ?>
                    {{ Form::select('month',$month_range, $selected, ['class'=>'form-control'] ) }}
                </div>                  
                <div class='col-md-2'>
                    <input type='submit' class="btn btn-primary" value="SUBMIT"  />
                </div>
            {{ Form::close() }}
            {{ Form::open(['class' => 'form-inline form-bordered activation_name ' . $filter_activation_name, 'method' => 'POST']) }} 
                <div class="col-md-2">
                    {{ Form::text('activation_name', old('activation_name'), [
                        'class' => 'form-control',
                        'placeholder' => 'Activation Code Name'
                    ]) }}
                </div> 
                <div class="col-md-2">
                    {{ Form::submit('Search', [
                        'class' => 'btn btn-primary'
                    ])}}
                </div>
            {{ Form::close() }}
            
        </div>
    </div>

     <?php
        $from = (!empty($date_from))? strtotime($date_from):'0';
        $to = (!empty($date_to))? strtotime($date_to):'0';
      ?> 
    <div class="col-md-12 form-group" id="codelist">
        {{ view('widgets.activationCodes.list')->with([
            'codes'=>$codes
        ])->render() }}
    </div>
    @include('Admin.ActivationCodes.views.delete-code')
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

        
        // $(document).ready(function(){
        //     $('#activation_table').DataTable({
        //         "ordering": false,
        //         // "searching": false,
        //         // "paging" : false,
        //         "lengthChange": false,
        //         "iDisplayLength": 50
        //     });
        // });

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


        $(document).on('change', '#filter-by', function(e){
            e.preventDefault();
            let val = $(this).find(":selected").val();
          
            if(val == 'date_range'){
                $('.monthly').addClass('hidden');
                $('.activation_name').addClass('hidden');
                $('.date-range').removeClass('hidden');
            }
            else if(val == 'monthly'){
                $('.date-range').addClass('hidden');
                $('.activation_name').addClass('hidden');
                $('.monthly').removeClass('hidden');
            }
            else if(val == 'activation_name'){
                $('.date-range').addClass('hidden');
                $('.monthly').addClass('hidden');
                $('.activation_name').removeClass('hidden');
            }
        })

        // //view reason
        // $(document).on('click','.btn-reason', function(e){
        //     e.preventDefault();
        //     var id = $(this).attr('data-id');
        //     var reason_url = '/admin/activation-codes/reason/'+id;
        //    $.ajax({
        //     type : 'GET',
        //     url  : reason_url,
        //     success : function(data) {
        //           if(data.errors)
        //           {
        //             $('#error_message').text(data.errors);
        //           }
        //           else {
        //               $('#reason').val(data.reason);
        //               $('.modal-footer').addClass('hidden');
        //               $('#delete_modal').modal('show');
        //           }
        //       }
        //   });
        // });

        // // delete function
        // $(document).on('click','.btn-delete', function(e){
        //     e.preventDefault();
        //    $('#activation_id').val($(this).attr('data-id'));
        //    $('#delete_modal').modal('show');
        // });
        
        // var table_list = $('#codelist');
        // $(document).on('click','#delete_submit',function(e){
        //    e.preventDefault();
        //    var form = $('#delete_form');
        //    var id = $('#activation_id').val();
        //    var delete_url = '/admin/activation-codes/delete-code/'+id;
        //    $.ajax({
        //     type : 'POST',
        //     url  : delete_url,
        //     data : form.serialize(),
        //     success : function(data) {
        //           if(data.errors)
        //           {
        //             $('#error_message').text(data.errors);
        //             $('#error_message').removeClass('hidden');
        //           }
        //           else {
        //               $('#delete_modal').modal('hide');  
        //               $( "#codelist" ).load( window.location.href+" #codelist" );
        //           }
        //       }
        //   });
        // });

        // $(document).on('hidden.bs.modal','#delete_modal', function() {
        //     $('#delete_form')[0].reset();
        //     $('#error_message').addClass('hidden');
        //     $('.modal-footer').removeClass('hidden');
        // });
    </script>

    <style>
        .code_name{
            margin-bottom: 10px;
            margin-left: 0px;
        }
    </style>
@stop
