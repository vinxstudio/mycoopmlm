@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 80%;">
            <div class="row py-3 align-items-center">
                <div class="col">
                    <a class="text-dark"  href="{{ URL::to('member/programServices') }}" >
                        <i class="fas fa-arrow-left fa-fw fa-2x align-middle fa-pull-left"></i>
                        <span class="h4 align-middle">Program and Services</span>
                    </a>
                </div>
                <div class="col-sm-8 text-center">
                    <i class="fas fa-hospital fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">Hospitalization</span>
                </div>
                <div class="col"></div>
            </div>
            <div class="row py-3 align-items-center">
                <div class="col-md-5">
                    <img @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif alt="">
                </div>
                <div class="col-md-7 text-center">
                    <div class="panel-body no-padding">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        {{ Form::open([ 'url'=> 'member/programServices/hospitalization/store']) }}
                            <div class="row">
                                <div class="col text-center">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label">New</label>
                                                <input type="radio" class="form-control" name="type" value="1" checked="" />
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="col-sm-3 control-label">Renewal</label>
                                                <input type="radio" class="form-control" name="type" value="2"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('application_date') }}
                                        <label class="control-label">Date</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="application_date" value="{{ date('m/d/Y') }}" required="" disabled="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('mccrc_control_no') }}
                                        <label class="control-label">MCCRC Control No.</label>
                                        <div class="">
                                            <input type="text" placeholder="" class="form-control"  name="mccrc_control_no" value="{{ old('mccrc_control_no') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('cooperative_name') }}
                                        <label class="control-label">Name of Cooperative</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="cooperative_name" value="{{ old('cooperative_name') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('cooperative_address') }}
                                        <label class="control-label">Address</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="cooperative_address" value="{{ old('cooperative_address') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3>THE MEMBER</h3>
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('last_name') }}
                                        <label class="control-label">Surname</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="last_name" value="{{ old('last_name', $user->last_name) }}" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('first_name') }}
                                        <label class="control-label">First Name</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="first_name" value="{{ old('first_name', $user->first_name) }}" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('middle_name') }}
                                        <label class="control-label">Middle Name</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('present_address') }}
                                        <label class="control-label">Present Address</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="present_address" 
                                                value="{{ old('present_address', $user->present_street.' '.$user->present_barangay.' '.$user->present_town.' '.$user->present_city.' '.$user->present_province) }}" 
                                                required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('present_address_zip_code') }}
                                        <label class="control-label">Zip Code</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="present_address_zip_code" value="{{ old('present_address_zip_code') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('provincial_address') }}
                                        <label class="control-label">Provincial Address</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="provincial_address" 
                                                value="{{ old('provincial_address', $user->provincial_street.' '.$user->provincial_barangay.' '.$user->provincial_town.' '.$user->provincial_city.' '.$user->provincial_province) }}"
                                                required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('provincial_address_zip_code') }}
                                        <label class="control-label">Zip Code</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="provincial_address_zip_code" value="{{ old('provincial_address_zip_code') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('civil_status') }}
                                        <label class="control-label">Civil Status</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="civil_status" value="{{ old('civil_status') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('sex') }}
                                        <label class="control-label">Sex</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="sex" value="{{ old('sex') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('contact_number') }}
                                        <label class="control-label">Contact Number</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="contact_number" value="{{ old('contact_number') }}" required="" max="255"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('email_address') }}
                                        <label class="control-label">Email Address</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="email_address" value="{{ old('email_address') }}" required="" max="255"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('facebook_account') }}
                                        <label class="control-label">Facebook Account</label>
                                        <div class="">
                                            <input type="text" class="form-control"  name="facebook_account" value="{{ old('facebook_account') }}" required="" max="255"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('occupation') }}
                                        <label class="control-label">Occupation</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="occupation" value="{{ old('occupation', $user->job_title) }}" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('employer_name') }}
                                        <label class="control-label">Name of Employer</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="employer_name" value="{{ old('employer_name', $user->employer_name) }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        {{ $errors->first('yrs_in_company') }}
                                        <label class="control-label">No. of Years in the Company</label>
                                        <div class="">
                                            <input type="number" step="any" min="0" class="form-control"  name="yrs_in_company" value="{{ old('yrs_in_company') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        {{ $errors->first('date_hired') }}
                                        <label class="control-label">Date Hired</label>
                                        <div class="">
                                            <input type="date" class="form-control"  name="date_hired" value="{{ old('date_hired') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        {{ $errors->first('employer_address') }}
                                        <label class="control-label">Address</label>
                                        <div class="">
                                            <input type="text" max="255" class="form-control"  name="employer_address" value="{{ old('employer_address') }}" required="" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3>IMMEDIATE FAMILY MEMBERS (Including parent's in law if not member of the cooperative.)</h3>
                            <div class="row">
                                <div class="col-11">
                                    <table>
                                      <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Last Name</th>
                                          <th scope="col">First Name</th>
                                          <th scope="col">Middle Name</th>
                                          <th scope="col">Relationship</th>
                                          <th scope="col">Birthdate</th>
                                          <th scope="col">Gender</th>
                                          <th scope="col">Civil Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @for($loop = 1; $loop <=3; $loop++)
                                            <tr>
                                                <th scope="row">{{ $loop }}</th>
                                                <td><input type"text" max="255" required="" name="family_immediate[last_name][]"></td>
                                                <td><input type"text" max="255" required="" name="family_immediate[first_name][]"></td>
                                                <td><input type"text" max="255" required="" name="family_immediate[middle_name][]"></td>
                                                <td><input type"text" max="255" required="" name="family_immediate[relationship][]"></td>
                                                <td><input type"date" required="" name="family_immediate[birthdate][]"></td>
                                                <td>
                                                <select name="family_immediate[gender][]" required="">
                                                    <option value="Female" selected="">Female</option>
                                                    <option value="Male">Male</option>
                                                </select>
                                                </td>
                                                <td>
                                                    <select name="family_immediate[civil_status][]" required="">
                                                        <option value="Single" selected="">Single</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Divorced">Divorced</option>
                                                        <option value="Widowed">Widowed</option> 
                                                    </select>
                                                </td>
                                            </tr>
                                        @endfor
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::button('Apply', [
                                        'type'=>'submit',
                                        'value'=>'Apply',
                                        'class'=>'btn rounded-0 orange bg my-5'
                                    ]) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop