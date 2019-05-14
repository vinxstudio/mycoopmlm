@extends($layout)
@section('plugin_css')
    {{ LoadPlugin('dropzone', 'css') }}
    {{ LoadPlugin('sweet-alert', 'css') }}
@stop
@section('plugin_js')
    {{ LoadPlugin('dropzone', 'js') }}
    {{ LoadPlugin('sweet-alert', 'js') }}
    {{ LoadPlugin('dropzoneCallback', 'js') }}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-4">

            <div class="panel rounded shadow">
                <div class="panel-body photo-panel">
                    <div class="inner-all">
                        <ul class="list-unstyled">
                            <li class="text-center">
                                <img class="img-circle img-bordered-primary" width="100" height="100" src="{{ url($theUser->details->thePhoto) }}" alt="{{ $theUser->details->fullName }}">
                            </li>
                            <li class="text-center">
                                <h4 class="text-capitalize">{{ $theUser->details->fullName }}</h4>
                                <p class="text-muted">{{ $theUser->username }}</p>
                                <p class="text-muted text-capitalize">{{ ($theUser->role != 'member') ? strtoupper($theUser->role) : $theUser->account->account_id }}</p>
                                <p class="text-muted text-capitalize"><a href="" class="change-photo">change photo</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body change-photo-panel hidden">
                    <p class="text-muted text-capitalize"><a href="" class="cancel-change-photo">cancel</a></p>
                    {{ Form::open([
                        'class'=>'dropzone',
                        'files'=>'true',
                        'id'=>'dropzone-custom'
                    ]) }}

                        <div class="fallback">
                            <input name="file" type="file" />
                        </div>
                    {{ Form::close() }}
                </div>
            </div><!-- /.panel -->

            @if ($theUser->role == 'member')
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('profile.bank_details') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body no-padding rounded">
                    <ul class="list-group no-margin">
                        <li class="list-group-item"><i class="fa fa-bank mr-5"></i> {{ $theUser->details->bank_name }}</li>
                        <li class="list-group-item"><i class="fa fa-bank mr-5"></i> {{ $theUser->details->account_name }}</li>
                        <li class="list-group-item"><i class="fa fa-bank mr-5"></i> {{ $theUser->details->account_number }}</li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-9 col-md-9 col-sm-8">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('profile.update') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body rounded">
                    {{ Form::open() }}
                        @include('widgets.advance_profile_fields')

                        <div class="form-group">
                            {{ Form::button(Lang::get('labels.update'), [
                                'type'=>'submit',
                                'value'=>'update',
                                'name'=>'update',
                                'class'=>'btn btn-theme'
                            ]) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div><!-- /.row -->
@stop