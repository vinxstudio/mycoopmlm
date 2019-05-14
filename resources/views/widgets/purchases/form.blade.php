<div class="col-md-6 col-xs-12 col-sm-12">
    <div class="panel panel-theme rounded shadow">
        <div class="panel-heading">
            <h3 class="panel-title">{{ Lang::get('products.encode_purchase') }}</h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            {{ Form::open() }}
            <div class="form-group">
                {{ validationError($errors, 'code') }}
                <label class="control-label">{{ Lang::get('products.code') }}</label>
                {{ Form::text('code', old('code', isset($purchaseCode->code) ? $purchaseCode->code : null), [
                    'class'=>'form-control'
                ]) }}
            </div>
            <div class="form-group">
                {{ validationError($errors, 'password') }}
                <label class="control-label">{{ Lang::get('products.password') }}</label>
                {{ Form::text('password', old('password', isset($purchaseCode->password) ? $purchaseCode->password : null), [
                    'class'=>'form-control'
                ]) }}
            </div>
            {{--@if ($company->multiple_account == 0)--}}
                <div class="form-group {{ ($company->multiple_account == 0) ? '' : 'hidden' }}">
                    {{ validationError($errors, 'account_id') }}
                    <label class="control-label">{{ Lang::get('products.select_account') }}</label>
                    <select class="form-control chosen-select" name="account_id">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->code->account_id; }}</option>
                        @endforeach
                    </select>
                </div>
            {{--@endif--}}
            <div class="form-group">
                {{ Form::button(Lang::get('labels.save'), [
                    'type'=>'submit',
                    'value'=>'save',
                    'name'=>'save',
                    'class'=>'btn btn-primary'
                ]) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>