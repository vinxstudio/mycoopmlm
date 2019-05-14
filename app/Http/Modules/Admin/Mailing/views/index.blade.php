@extends($template)
@section('content')
    {{ Form::open() }}
        <div class="col-md-12 pull-right mb-10 mt-10">
            {{ Form::button(Lang::get('labels.save'), [
                'type'=>'submit',
                'value'=>'save_maintenance',
                'name'=>'save_maintenance',
                'class'=>'btn btn-primary mt-10'
            ]); }}

            <div class="form-group pull-right">
                <label class="col-sm-12 text-right">{{ Lang::get('labels.require_user_email') }}</label><br/>
                <div class="col-sm-7">
                    <?php $checked = (isEmailRequired()) ? 'checked="checked"' : null ?>
                    <input type="checkbox" class="switch" {{ $checked }} name="require_email" data-on-text="ON" data-off-text="OFF" data-on-color="teal">
                </div>
            </div>
        </div>
        <div class="col-md-12 pull-left">
            <div class="panel panel-tab panel-tab-double panel-tab-vertical row no-margin mb-15 rounded shadow">
                <!-- Start tabs heading -->
                <div class="panel-heading no-padding col-lg-3 col-md-3 col-sm-3">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab3-1" data-toggle="tab" aria-expanded="true">
                                <i class="fa fa-user"></i>
                                <div>
                                    <span class="text-strong">{{ Lang::get('mailing.registration') }}</span>
                                    <span>{{ Lang::get('mailing.after_registration') }}</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3-2" data-toggle="tab" aria-expanded="false">
                                <i class="fa fa-check-circle"></i>
                                <div>
                                    <span class="text-strong">{{ Lang::get('mailing.double_verification') }}</span>
                                    <span>{{ Lang::get('mailing.code_after_login') }}</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3-3" data-toggle="tab" aria-expanded="false">
                                <i class="fa fa-credit-card"></i>
                                <div>
                                    <span class="text-strong">{{ Lang::get('mailing.withdrawal') }}</span>
                                    <span>{{ Lang::get('mailing.withdrawal_mail') }}</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3-4" data-toggle="tab">
                                <i class="fa fa-file-text"></i>
                                <div>
                                    <span class="text-strong">{{ Lang::get('mailing.cheatsheet') }}</span>
                                    <span>{{ Lang::get('mailing.variables') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div><!-- /.panel-heading -->
                <!--/ End tabs heading -->

                <!-- Start tabs content -->
                <div class="panel-body col-lg-9 col-md-9 col-sm-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab3-1">
                            <textarea class="summernote-element" name="{{ REGISTRATION_KEY }}" id="" cols="30" rows="10">{{ old(REGISTRATION_KEY, (isset($emailTemplates[REGISTRATION_KEY])) ? $emailTemplates[REGISTRATION_KEY] : null) }}</textarea>
                        </div>
                        <div class="tab-pane fade" id="tab3-2">
                            <textarea class="summernote-element" name="{{ LOGIN_KEY }}" id="" cols="30" rows="10">{{ old(LOGIN_KEY, (isset($emailTemplates[LOGIN_KEY])) ? $emailTemplates[LOGIN_KEY] : null) }}</textarea>
                        </div>
                        <div class="tab-pane fade" id="tab3-3">
                            <textarea class="summernote-element" name="{{ WITHDRAWAL_KEY }}" id="" cols="30" rows="10">{{ old(WITHDRAWAL_KEY, (isset($emailTemplates[WITHDRAWAL_KEY])) ? $emailTemplates[WITHDRAWAL_KEY] : null) }}</textarea>
                        </div>
                        <div class="tab-pane fade" id="tab3-4">
                            {{ view('widgets.mailing.keywordsTable')->with([
                                'keywords'=>$keywords
                            ])->render() }}
                        </div>
                    </div>
                </div><!-- /.panel-body -->
                <!--/ End tabs content -->
            </div>
        </div>
    {{ Form::close() }}
@stop
@section('custom_includes')
    {{ Html::style('public/assets/global/plugins/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}
    {{ Html::script('public/assets/global/plugins/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}
    {{ Html::script('public/plugins/summernote/summernote.min.js') }}
    {{ Html::style('public/plugins/summernote/summernote.css') }}
    {{ Html::script('public/custom/js/code-settings.js') }}
@stop