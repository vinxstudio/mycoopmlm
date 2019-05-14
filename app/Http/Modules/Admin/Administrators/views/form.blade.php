@extends($template)
@section('content')
    {{ Form::open() }}

    <div class="col-md-6 col-xs-12 col-sm-12 pull-left">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $formTitle }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                @if ($member_id > 0 and $company->multiple_account > 0 or $member_id <= 0)
                    @include('widgets.basic_profile_fields')
                @endif

                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 pull-left">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('labels.access_control') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                @foreach ($menus as $group=>$adminMenu)
                    <div class="form-group form-group-divider pull-left" style="width:100%">
                        <div class="form-inner">
                            <h4 class="no-margin">{{ ucwords(str_replace('-', ' ', $group)) }}</h4>
                        </div>
                    </div>
                    <div class="pull-left row col-md-12" style="padding:10px 25px;">
                        @foreach ($adminMenu as $menuName)
                            <div class="form-group">
                                <div class="ckbox ckbox-theme">
                                    <input type="checkbox" id="{{ $menuName }}" name="modules[]" value="{{ $menuName }}"/>
                                    <label for="{{ $menuName }}">{{ ucwords(str_replace('-', ' ', $menuName)) }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    </div>

    <div class="form-group">
        {{ Form::button(Lang::get('labels.save'), [
            'class'=>'btn btn-primary pull-right',
            'name'=>'save',
            'value'=>'save',
            'type'=>'submit'
        ]) }}
    </div>
    {{ Form::close() }}

@stop