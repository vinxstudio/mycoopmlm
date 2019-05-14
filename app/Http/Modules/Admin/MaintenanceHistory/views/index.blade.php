@extends('layouts.master')
@section('content')
  <?php
    set_time_limit(3000);

    $new_from_date = date("F d, Y", strtotime($date_from));
    $new_to_date = date("F d, Y", strtotime($date_to));

    $total = 0;
    $my_c_total = 0;

  ?>
   <div class='col-md-12'>
        <div class="col-md-6">
          <h2>Maintenance Report</h2>
          <h4>From : {{ $new_from_date }} To : {{ $new_to_date }}</h4> 
        </div>
        <!--<div class="col-md-6">
            <h4 class="pull-right">All Total Maintenance Amount: {{ number_format($total_maintenance, 2) }}</h4>
        </div>-->
    </div>
    <div class="row">
      <div class="col-md-12">
          {{ Form::open(['class'=>'form-horizontal form-bordered date-range']) }}
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
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class='input-group date'>
                      <?php
                        $date_from = (!empty($date_from))? $date_from:'0';
                        $date_to = (!empty($date_to))? $date_to:'0';
                      ?>
                      <a class="btn btn-success pull-right" href="{{ url('admin/export-maintenance/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Maintenance Report</a>
                    </div>
                    
                </div>
            </div>
          {{ Form::close() }}
            
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>Full Name</th>
                <th>Username</th>
                <th>Account ID.</th>
                <th>From</th> 
                <th>CBU</th>
                <th>MY-C</th>
                <th>Date</th>
                <th>Receipt</th>
            </thead>
            <tbody>
              @if (!$maintenance->isEmpty())
                @foreach ($maintenance as $details)
                    <?php
                      $firstname = (!empty($details['first_name'])) ? $details['first_name'] : '';
                      $lastname = (!empty($details['last_name'])) ? $details['last_name'] : '';
                      $username = (!empty($details['username'])) ? $details['username'] : '';
                      $account_id = (!empty($details['account_id'])) ? $details['account_id'] : '';
                      $amount = (!empty($details['CBU'])) ? $details['CBU'] : 0;
                      $date = (!empty($details['created_at'])) ? $details['created_at'] : '';
                      $total += $amount;
                      $my_c_total += $details['my_c'];
                      $receipt = url() . '/public/uploads/receipt/maintenance/' . $details['receipt'];
                    ?>
                    <tr>
                        <td>{{ $firstname.' '.$lastname }}</td>
                        <td>{{ $username }}</td>
                        <td>{{ $account_id }}</td>
                        <td>{{ $details['from'] }}</td>
                        <td>{{ number_format($amount, 2) }}</td>
                        <td>{{ number_format($details['my_c'], 2) }}</td>
                        <td>{{ $date }}</td>
                        @if(!empty($details['receipt']))
                          <td><button class="btn btn-info btn-img" data-src={{ $receipt }}>View Receipt</button></td>
                        @else
                          <td></td>
                        @endif
                    </tr>
                @endforeach
              @else
                <tr>
                    <td colspan="6" class="text-center">
                        <i>No Maintenance Report Found</i>
                    </td>
                </tr>
              @endif
            </tbody>
            <tfoot>
                <tr class="strong">
                    <td colspan="4">Total</td>
                    <td>{{ number_format($total, 2) }}</td>
                    <td>{{ number_format($my_c_total, 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
        </div>
      </div>
      {{ $maintenance->render() }}
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
          $(document).ready(function(){
              $(".btn-img").click(function(){
                  var img_src = $(this).attr("data-src");
                  $("#modal_image").on("shown.bs.modal", function () {
                      $(".full_image").attr("src", img_src);
                      $(this).appendTo("body");
                  }).modal('show');
              })
          });
      </script>

      <!-- Modal -->
      <div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Receipt Image</h4>
                  </div>
                  <div class="modal-body">
                      <img class="full_image" style="width:100%;">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>
@stop
