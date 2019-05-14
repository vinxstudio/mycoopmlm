@extends($template)
@section('content')
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $formTitle }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ Form::open() }}
                    @if ($member_id > 0 and $company->multiple_account > 0 or $member_id <= 0)
                        @include('widgets.basic_profile_fields')
                    @endif
                    @if ($id <= 0)
                        <div class="form-group">
                            {{ validationError($errors, 'activation_code') }}
                            <label class="control-label">{{ Lang::get('members.select_activation_code') }}</label>
                            <select class="form-control chosen-select" name="activation_code">
                                <option value="">{{ Lang::get('members.select_code') }}</option>
                                @foreach ($activationCodes as $code)
                                    <option value="{{ $code->id }}">{{ sprintf('%s - %s - %s', $code->code, $code->account_id, ucfirst($code->type)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            {{ validationError($errors, 'upline') }}
                            <label class="control-label">{{ Lang::get('labels.upline') }}</label>
                            {{ Form::select('upline', [''=>Lang::get('members.select_upline')] + $uplineDropdown, old('upline'), [
                                'class'=>'form-control chosen-select'
                            ]) }}
                        </div>

                        <div class="form-group {{ ($member_id > 0) ? 'hidden' : '' }}">
                            {{ validationError($errors, 'sponsor') }}
                            <label class="control-label">{{ Lang::get('labels.sponsor') }} ({{ Lang::get('labels.optional') }})</label>
                            {{ Form::select('sponsor', [''=>Lang::get('members.select_sponsor')] + $accountsDropdown, old('sponsor', $member_id), [
                                'class'=>'form-control chosen-select'
                            ]) }}
                        </div>

                        <div class="form-group">
                            {{ validationError($errors, 'node_placement') }}
                            <label class="control-label">{{ Lang::get('members.node_placement') }}</label>
                            {{ Form::select('node_placement', [
                                'left'=>Lang::get('labels.left'),
                                'right'=>Lang::get('labels.right')
                            ], old('node_placement'), [
                                'class'=>'form-control chosen-select',
                            ]) }}
                        </div>
                    @endif
                    <div class="form-group">
                        {{ Form::button(Lang::get('labels.save'), [
                            'class'=>'btn btn-primary pull-right',
                            'name'=>'save',
                            'value'=>'save',
                            'type'=>'submit'
                        ]) }}
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop