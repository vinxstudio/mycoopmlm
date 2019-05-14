@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div style="margin: 0 auto; width: 70%;">
            <div class="col-10">
                <div class="row py-3 text-center align-items-center">
                    <div class="col-8">
                        <span class="h3 align-middle">Financing</span>
                    </div>
                </div>
                <div class="col-12 p-5 text-center grey bg mb-1" style="background-color: #d2d2d2;">
                    <div class="h4 mb-5 text-sm-left">Requirements</div>
                    <div class="text-sm-left pl-5">
                        <p>Complete Filled - up Loan Application Form and other attachedment.<br>
                            <small class="red px-5">(Always Indicate N/A or Not Applicable if the required data is not applicable)</small></p>
                        <p>TIN Number (BIR)</p>
                        <p>Photocopy Valid ID of Member & Spouse</p>
                        <p>Latest Barangay Clearance (Loan Purpose)</p>
                        <p>Proof of Income:<br>
                            <span class="pl-5">Business Permit </span><br>
                            <span class="pl-5">Business Permit </span>
                        </p>
                        <p>Collateral:<br>
                            <span class="pl-5">CR & OR for Vichle</span><br>
                            <span class="pl-5">Lot Title for Parcel of Land</span>
                        </p>
                    </div>
                </div>
                <div class="col-12 p-10 text-center grey bg mb-5" style="background-color: #d2d2d2;">
                    <img src="{{ asset('public/program_services/logo-big.png') }}" alt="">
                    <div class="h4 mt-3">LOAN APPLICATION FORM</div>
                    <div class="h4 mb-5">Category “C”</div>
                    <div class="form-group row m-5">
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Amount Applied</label>
                            <input disabled="" step="any" placeholder="0.00" class="form-control"  value="{{ $data->application_amount }}" />
                        </div>
                        <div class="offset-sm-4 col-sm-4 text-sm-left">
                            <label class="control-label ">Date</label>
                            <input disabled="" class="form-control"  value="{{ $data->application_date }}"}" disabled="" />
                        </div>
                        <div class="offset-sm-4 col-sm-4 text-sm-left">
                            <label class="control-label ">Status</label>
                            <input disabled="" class="form-control"  value="{{ $status_string }}"}" disabled="" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label">Loan Type</label>
                            <input disabled="" class="form-control"  value="{{ $status_string }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label">If Others</label>
                            <input disabled="" class="form-control" value="{{ $data->loan_type_others }}" placeholder="(For others.)" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-10 text-sm-left">
                            <label class="control-label">Purpose</label>
                            <input disabled="" class="form-control"  value="{{ $data->purpose }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">Loan Term</label>
                            <input disabled="" class="form-control"  value="{{ $data->loan_term }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label">Repayment</label>
                            <input disabled="" class="form-control" value="{{ $data->repayment_string }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">Mode of Payment</label>
                            <input disabled="" class="form-control" value="{{ $data->payment_mode }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label">Loan Class</label>
                            <input disabled class="form-control" value="{{ $data->class_string }}" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Personal Information of the Borrower</strong>
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Surname</label>
                            <input disabled="" class="form-control"  value="{{ $data->last_name }}" }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">First Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->first_name }}" }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Middle Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->middle_name }}" }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Present Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->present_address }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label">No. of Years of stay</label>
                            <input disabled="" class="form-control"  value="{{ $data->present_address_no_stay }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Tel./Cel. No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->present_address_contact }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Provincial Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->provincial_address }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Tel./Cel. No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->provincial_address_contact }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">Civil Status</label>
                            <input disabled="" class="form-control" value="{{ $data->civil_status }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">Sex</label>
                            <input disabled class="form-control" value="{{ $data->sex }}" />
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-2 text-sm-left">
                            <div class="col"><label class="control-label ">No. of Dependants</label></div>
                            <div class="row">
                                <div class="col">
                                    <label></label>
                                    <input disabled="" class="form-control"  value="{{ $data->no_of_dependents }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 text-sm-left">
                            <div class="col"><label>No. of Children in School</label></div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="control-label col-form-label">Elementary</label>
                                    <input disabled="" class="form-control"  value="{{ $data->no_in_elementary }}"/>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label col-form-label">High School</label>
                                    <input disabled="" class="form-control"  value="{{ $data->no_in_highschool }}"/>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label col-form-label">College</label>
                                    <input disabled="" class="form-control"  value="{{ $data->no_in_college }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Name of Employer</label>
                            <input disabled="" class="form-control"  value="{{ $data->employer_name }}" }}" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="control-label ">Position</label>
                            <input disabled="" class="form-control"  value="{{ $data->position }}" }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-10 text-sm-left">
                            <label class="control-label ">Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->employer_address }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">Tel. No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->employer_contact }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">Salary</label>
                            <input disabled="" step="any" class="form-control"  value="{{ $data->salary }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">Employment Status</label>
                            <input disabled="" class="form-control"  value="{{ $data->employment_status }}" />
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <label class="control-label ">No. of Years in the company</label>
                            <input disabled="" step="any" class="form-control"  value="{{ $data->no_of_yrs_company }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Father’s Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->fathers_name }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label">Address</label>
                            <input disabled class="form-control"  value="{{ $data->fathers_address }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label">Tel. No./ Cell No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->fathers_contact }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Mother’s Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->mothers_name }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->mothers_address }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">Tel. No./ Cell No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->mothers_contact }}" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Business Data</strong>
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Nature of Business</label>
                            <input disabled="" class="form-control"  value="{{ $data->business_nature }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">Monthly Income</label>
                            <input disabled="" step="any" class="form-control"  value="{{ $data->monthly_income }}" />
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Present Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->business_address }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">No. of Years in the business</label>
                            <input disabled="" step="any" class="form-control"  value="{{ $data->yrs_in_business }}" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Data on Spouse</strong>
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Name of Spouse</label>
                            <input disabled="" class="form-control"  value="{{ $data->spouse_name }}" />
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row m-5">
                        <div class="col-sm-8 text-sm-left">
                            <label class="control-label ">Name of Employer</label>
                            <input disabled="" class="form-control"  value="{{ $data->spouse_employer }}" />
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="control-label ">Tel No./ Cell No.</label>
                            <input disabled="" class="form-control"  value="{{ $data->spouse_employer_contact }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop