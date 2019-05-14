@extends('layouts.members')
@section('content')
    {{-- left side --}}
    {{-- encode product codes --}}
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">Encode Product Codes</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{-- if successfull encode --}}
                {{-- check if have session --}}
                {{-- then check if have type and type is success --}}
                {{-- display message --}}
                @if(session()->has('status'))
                    <?php 
                        $status = session()->get('status');
                    ?>
                    @if(isset($status['type']) && $status['type'] == 'success')
                        <div class="alert {{ $status['class'] }}" id="alert-info" role="alert">
                            {{ $status['message'] }}
                        </div>
                    @endif
                @endif
                {{ Form2::open(['url' => 'member/purchases/encoded-product-codes/', 'method' => 'POST'])}}
                    {{-- product code input --}}
                    <div class="form-group">
                        {{-- show errors --}}
                        {{ validationError($errors, 'product_code') }}
                        <label class="control-label">Product Code</label>
                        {{ Form2::text('product_code', old('code', (isset($product_code) && !$product_code->isEmpty()) ? $product_code->code : ''), ['class' => 'form-control']) }}
                    </div>
                    {{-- product code password input --}}
                    <div class="form-group">
                        {{ validationError($errors, 'product_code_password') }}
                        <label class="control-label">Product Code Password</label>
                        {{ Form2::text('product_code_password', old('password', (isset($product_code) && !$product_code->isEmpty()) ? $product_code->code : ''), ['class' => 'form-control']) }}
                    </div>
                    {{-- accounts --}}
                    <div class="form-group @if($company->multiple_account == 0) '' @else hidden @endif">
                        {{ validationError($errors, 'account_id') }}
                        <label class="control-label">Select Account</label>
                        <select class="form-control chosen-select" name="account_id">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->code->account_id; }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- hidden input for products --}}
                    <input type="hidden" name="purchases" value="@if(isset($purchases)) {{ $purchases }} @endif" />
                    {{-- button --}}
                    <div class="form-group">
                        {{ 
                            Form2::button('Encode', [
                                'type' => 'submit',
                                'value' => 'save',
                                'name' => 'encode',
                                'class' => 'btn btn-primary'
                            ]) 
                        }}
                    </div>
                {{ Form2::close() }}
            </div>
        </div>
    </div>
    {{-- right side --}}
    {{-- display products of the encoded product codes --}}
    <div class="col-md-6 col-xs-12">
        <table class="table table-bordered table-hover">
            <thead>
                <th>Product</th>
                <th>Amount</th>
                <th>Date Purchased</th>
            </thead>
            <tbody>
                @if(session()->has('purchases') && !session()->get('purchases')->isEmpty())
                    @foreach (session()->get('purchases') as $purchase)
                        <tr>
                            {{-- dispaly products of encoded code --}}
                            <td>{{ $purchase->name }}</td>
                            <td>{{ number_format($purchase->price, 2) }}</td>
                            <td>{{ date('F d, Y', $purchase->date_purchased) }}</td>
                        </tr>
                    @endforeach
                @endif
                    <tr class="success">
                        <td><center>Total</center></td>
                        <td colspan="2">
                            @if(session()->has('purchases') && !session()->get('purchases')->isEmpty())
                                {{-- create variable to store sum of product prices --}} 
                                {{-- loop of all purchases and add to sum --}}
                                <?php $sumOfPrice = 0; ?>
                                @foreach (session()->get('purchases') as $purchase)
                                    {{ number_format($sumOfPrice += $purchase->price, 2) }}
                                @endforeach
                            @endif
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="encodeProductCodeModal" tabindex="-1" role="dialog" aria-labelledby="encodeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="font-weight-bold modal-title inline" id="modal-title">Modal title</h4>
                    <button type="button" class="close inline" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-text">
          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id='modal-confirm'>Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('status'))
        <script>
            var isNotEqualAccountId = {{ json_encode(session()->get('status'), JSON_HEX_TAG) }};
        </script>
    @endif

    <script>
        
        $(document).ready(function(){

            $('#encodeProductCodeModal').appendTo('body');

            var info = $('#alert-info');

            // if alert info has hide class
            // add hide class in 2.5 seconds
            if(!info.hasClass('hide')){
                setTimeout(function(){
                    info.addClass('hide');
                }, 2500);
            }
            
            // if is not equal account id is not undefined
            // show modal
            // that account id is not equal to account id of code
            // but the same user
            if(typeof isNotEqualAccountId !== 'undefined'){

                let modal = $('#encodeProductCodeModal');
                let title = modal.find('#modal-title');
                let text = modal.find('#modal-text');

                title.text(isNotEqualAccountId['isNotEqualAccountIdData']['title']);
                text.append(isNotEqualAccountId['isNotEqualAccountIdData']['message']);

                setTimeout(function(){
                    modal.modal('show');
                }, 500)

            }
            
            // if confirm in modal is click
            // add another hidden input
            $('#modal-confirm').click(function(e){
                let form = $('form');

                let userUseID = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'use_user_id')
                            .val('true');
                    
                form.append(userUseID);

                form.submit();
            });


        });
        
    </script>


    <style>
        .w80p{
            width: 80% !important; 
        }
        .inline{
            display: inline-block;
        }

    </style>

@stop