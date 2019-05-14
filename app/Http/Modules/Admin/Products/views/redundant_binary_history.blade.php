@extends('layouts.master')
@section('content')
    <div class="panel panel-theme rounded shadow">
        {{-- info notifications --}}
        <div class="alert @if(session('update_status')) {{ session('update_status') }} @else hide @endif" id="redundant_binary_info" role="alert">
            {{ session('update_message') }}
        </div>
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Redundant Binary History</h3>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="panel-body form-body col-md-12">
            <div class="col-md-12">
                <h3>
                    Redundant Binary Points History
                </h3>
                <h4>
                    From : {{ date('F d, Y', strtotime($date_from)) }} To : {{ date('F d, Y', strtotime($date_to)) }}
                </h4>
            </div>
            <div class="col-md-12 filter">

                <div class="hr-border"></div>
                <form class="mt-10 mb-10">
                    <div class="form-inline">
                        <div class="form-group"> 
                            <label>From</label>
                            <div class='input-group date' id='datefrom'>
                                <input type='text' class="form-control" disabled />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group"> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>To</label>
                            <div class='input-group date' id='dateto'>
                                <input type='text' class="form-control" disabled />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary ml-10 mr-10" value="Submit" disabled/>

                    </div>
                </form>
                <form method="GET" class="mt-10 mb-10">
                    <div class="hr-border"></div>
                    <div class="col-md-12 mt-20 form-inline">
                        <label>
                            Type
                        </label>
                        <select class="form-control" name="type">
                            <option selected style="display: none">
                                
                            </option>
                            <option value="add_points" @if($type == 'add_points') selected @endif>
                                Points Given
                            </option>
                            <option value="deduct_points" @if($type == 'deduct_points') selected @endif >
                                Paired Points
                            </option>

                        </select>
        
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                            Username
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="Username"/>

                        <input type="submit" class="btn btn-primary ml-10 mr-10" value="Submit"/>
                    </div>
                </form>           
            </div>
            <div class="clearfix"></div>
            
            <div class="note">
                <p>
                    Note <i>Paired points don't have a product purchaser and product code</i>
                </p>
            </div>
        </div>
    </div>
    <div class="h-300px">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>
                    Product Purchaser
                </th>
                <th>
                    Points Given To
                </th>
                <th>
                    Node
                </th>
                <th>
                    Added / Deducted
                </th>
                <th>
                    Points
                </th>
                <th>
                    Product Code
                </th>
                <th>
                    Date ( Added / Paired )
                </th>
            </tr>
        </thead>
        <tbody>
            @if(isset($history) && count($history) > 0)
                @foreach ($history as $hist)
                    <tr>
                        <td>
                            @if($hist->purchases_name == 'N/A')
                                {{ $hist->purchases_name }}
                            @else
                                Paired
                            @endif
                        </td>
                        <td>
                            {{ $hist->given_points_name }}
                        </td>
                        <td>
                            @if($hist->points_node == 'both')
                                Left and Right
                            @elseif($hist->points_node == 'left' || $hist->points_node == 'right')
                                {{ ucfirst($hist->points_node) }}
                            @endif
                        </td>
                        <td>
                            @if($hist->type == 'add_points')
                                Added Points
                            @elseif($hist->type == 'deduct_points')
                                Deducted Points
                            @endif
                        </td>
                        <td>
                            {{ number_format($hist->amount, 2) }}
                        </td>
                        <td>

                            {{ isset($hist->product_code_use) ? $hist->product_code_use : 'Paired' }}
                        </td>
                        <td>
                            {{ date('F d, Y - h:i A', strtotime($hist->created_at)) }}
                        </td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="7">
                            <center>
                                <strong>
                                    No Member with a username of {{ isset($_GET['name']) ? $_GET['name'] : 'N / A' }}
                                </strong>
                            </center>
                        </td>
                    </tr>
            @endif
        </tbody>
    </table>

    {{ $history->appends(Input::except('page'))->render(); }}

    <script>
    
    
        $(document).ready(function(){

            $( "#datefrom" ).datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: false
            });
            $( "#dateto" ).datetimepicker({
                format: 'YYYY-MM-DD',
                defaultDate: false,
                useCurrent: true
            });

            $("#datefrom").on("dp.change", function (e) {
                $('#dateto').data("DateTimePicker").minDate(e.date);
            });

            $("#dateto").on("dp.change", function (e) {
                $('#datefrom').data("DateTimePicker").maxDate(e.date);
            });



        });
        
    </script>

    <style>
        
        .w-200px{
           width: 200px;   
        }
        .h-300px{
           height: 300px !important;   
        }

        .filter{
            margin-top: 35px;
        }
  
        th{
            background-color: #212529 !important;
            border-color: #32383e !important;
            color: #ffffff;
        }
        td{
            padding: 10px;
        }

        .hr-border{
            width: 100%;
            border-width: .50px;
            border-style: ridge;
            border-color: #2D6581;
        }

        .note{
            display: block;
            margin-top: 30px !important;
            margin-left: 30px;

        }

    </style>
@stop