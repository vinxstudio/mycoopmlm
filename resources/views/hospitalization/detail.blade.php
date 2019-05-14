@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 80%;">
            <div class="row py-3 align-items-center">
                <div class="col text-center mb-10">
                    <i class="fas fa-hospital fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">Hospitalization</span>
                </div>
                <div class="col"></div>
            </div>
            <div class="row py-3 align-items-center">
                <div class="col-md-5 text-center">
                    <img width="90%" @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif alt="">
                </div>
                <div class="col-md-7 text-center">
                    <div class="panel-body no-padding">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Date Filed</label>
                                    <div class="">
                                        <input class="form-control"  value="{{ $data->created_at }}"  disabled="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">MCCRC Control No.</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->mccrc_control_no }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Name of Cooperative</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->cooperative_name }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->cooperative_address }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3>THE MEMBER</h3>
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Surname</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->last_name }}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->first_name }}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->middle_name }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Present Address</label>
                                    <div class="">
                                        <input disabled="" class="form-control" value="{{ $data->present_address }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->present_address_zip_code }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Provincial Address</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  
                                            value="{{ $data->provincial_address }}"
                                             />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->provincial_address_zip_code }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Civil Status</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->civil_status }}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Sex</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->sex }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Contact Number</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->contact_number }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->email_address }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Facebook Account</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->facebook_account }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Occupation</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->occupation }}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Name of Employer</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->employer_name }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">No. of Years in the Company</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->yrs_in_company }}"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Date Hired</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->date_hired }}"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <div class="">
                                        <input disabled="" class="form-control"  value="{{ $data->employer_address }}"  />
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
                                        <tr>
                                            <td scope="row"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_last_name_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_first_name_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_middle_name_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_relationship_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_birthdate_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_gender_1 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_civil_status_1 }}"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_last_name_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_first_name_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_middle_name_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_relationship_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_birthdate_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_gender_2 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_civil_status_2 }}"></td>
                                        </tr>
                                        <tr>
                                            <td scope="row"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_last_name_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_first_name_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_middle_name_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_relationship_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_birthdate_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_gender_3 }}"></td>
                                            <td><input disabled="" value="{{ $data->family_immediate_civil_status_3 }}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop