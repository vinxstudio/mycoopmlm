@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        {{ Form::open([ 'url'=> 'member/programServices/financing/store']) }}
        <div style="margin: 0 auto; width: 70%;">
            <div class="col-12">
                <div class="row py-3 text-center align-items-center">
                    <div class="col text-sm-left">
                        <a class="text-dark" href="">
                            <i class="fas fa-arrow-left fa-fw fa-2x align-middle fa-pull-left"></i>
                            <span class="h4 align-middle">Back</span>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <i class="fas fa-money-bill-alt fa-fw fa-3x align-middle"></i>
                        <span class="h3 align-middle">Financing</span>
                    </div>
                    <div class="col text-sm-right">
                        <a class="text-dark" href=""><i class="fas fa-download fa-fw fa-2x"></i></a>
                        <a class="text-dark" href=""><i class="fas fa-print fa-fw fa-2x"></i></a>
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
                <div class="col-12 p-5 text-center grey bg mb-5" style="background-color: #d2d2d2;">
                    <img src="{{ asset('public/program_services/logo-big.png') }}" alt="">
                    <div class="h4 mt-3">LOAN APPLICATION FORM</div>
                    <div class="h4 mb-5">Category “C”</div>
                    <div class="form-group row">
                        <div class="col-sm-4 text-sm-left">
                            <label class="">Amount Applied<em style="color:red;">{{ $errors->first('application_amount') }}</em></label>
                            <input type="number" step="any" placeholder="0.00" class="form-control"  name="application_amount" value="{{ old('application_amount') }}" required="" />
                        </div>
                        <div class="offset-sm-4 col-sm-4 text-sm-left">
                            <label class="">Date<em style="color:red;">{{ $errors->first('application_date') }}</em></label>
                            <input type="text" class="form-control"  name="application_date" value="{{ date('m/d/Y') }}" required="" disabled="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="col-12">Loan Type<em style="color:red;">{{ $errors->first('type') }}</em></label>
                            <div class="row mb-3">
                                <div class="col text-center">
                                    @foreach($types as $key => $type)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" value="{{ $key }}" checked="">
                                            <label class="form-check-label"><strong>{{ $type }}</strong></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="text" class="offset-sm-4 col-sm-4 form-control" name="loan_type_others" value="{{ old('loan_type_others') }}" placeholder="(For others.)" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Purpose<em style="color:red;">{{ $errors->first('purpose') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="purpose" value="{{ old('purpose') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Loan Term<em style="color:red;">{{ $errors->first('loan_term') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="loan_term" value="{{ old('loan_term') }}" required="" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="col-12">Repayment<em style="color:red;">{{ $errors->first('repayments') }}</em></label>
                            <div class="row mb-3">
                                <div class="col text-center">
                                    @foreach($repayments as $key => $repayment)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="repayments" value="{{ $key }}" checked=""/>
                                            <label class="form-check-label"><strong>{{ $repayment }}</strong></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Mode of Payment<em style="color:red;">{{ $errors->first('payment_mode') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="payment_mode" value="{{ old('payment_mode') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="col-12">Loan Class<em style="color:red;">{{ $errors->first('class') }}</em></label>
                            <div class="row mb-3">
                                <div class="col text-center">
                                    @foreach($classes as $key => $class)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="class" value="{{ $key }}" checked="" />
                                            <label class="form-check-label"><strong>{{ $class }}</strong></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Personal Information of the Borrower</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Surname<em style="color:red;">{{ $errors->first('last_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="last_name" value="{{ old('last_name', $user->last_name) }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">First Name<em style="color:red;">{{ $errors->first('first_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="first_name" value="{{ old('first_name', $user->first_name) }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Middle Name<em style="color:red;">{{ $errors->first('middle_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-sm-left">
                            <label class="">Present Address<em style="color:red;">{{ $errors->first('present_address') }}</em></label>
                            <input type="text" class="form-control"  name="present_address" 
                                                value="{{ old('present_address', $user->present_street.' '.$user->present_barangay.' '.$user->present_town.' '.$user->present_city.' '.$user->present_province) }}" 
                                                required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">No. of Years of stay<em style="color:red;">{{ $errors->first('present_address_no_stay') }}</em></label>
                            <input type="number" class="form-control"  name="present_address_no_stay" value="{{ old('present_address_no_stay') }}" required="" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="">Tel./Cel. No.<em style="color:red;">{{ $errors->first('present_address_contact') }}</em></label>
                            <input type="text" class="form-control"  name="present_address_contact" value="{{ old('present_address_contact') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Provincial Address<em style="color:red;">{{ $errors->first('provincial_address') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="provincial_address" 
                                                value="{{ old('provincial_address', $user->provincial_street.' '.$user->provincial_barangay.' '.$user->provincial_town.' '.$user->provincial_city.' '.$user->provincial_province) }}"
                                                required="" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="">Tel./Cel. No.<em style="color:red;">{{ $errors->first('provincial_address_contact') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="provincial_address_contact" value="{{ old('provincial_address_contact') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2 text-sm-left">
                            <label class="">Civil Status<em style="color:red;">{{ $errors->first('civil_status') }}</em></label>\
                            <select class="form-control" name="civil_status" value="{{ old('civil_status') }}" >
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>
                        <div class="col-sm-2 text-sm-left">
                            <label class="">Sex<em style="color:red;">{{ $errors->first('sex') }}</em></label>
                            <select class="form-control" name="sex" value="{{ old('sex') }}" >
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2 text-sm-left">
                            <label class="">No. of Dependants<em style="color:red;">{{ $errors->first('no_of_dependents') }}</em></label>
                            <input type="number" step="1" class="form-control"  name="no_of_dependents" value="{{ old('no_of_dependents') }}" required="" min="0"/>
                        </div>
                        <div class="col text-sm-left">
                            <label class="">No. of Children in School</label>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Elementary<em style="color:red;">{{ $errors->first('no_in_elementary') }}</em></label>
                                            <div class="col">
                                                <input type="number" step="1" class="form-control"  name="no_in_elementary" value="{{ old('no_in_elementary') }}" required="" min="0"/>
                                            </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">High School<em style="color:red;">{{ $errors->first('no_in_highschool') }}</em></label>
                                            <div class="col">
                                                <input type="number" step="1" class="form-control"  name="no_in_highschool" value="{{ old('no_in_highschool') }}" required="" min="0"/>
                                            </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">College<<em style="color:red;">{{ $errors->first('no_in_college') }}</em></label>
                                            <div class="col">
                                                <input type="number" step="1" class="form-control"  name="no_in_college" value="{{ old('no_in_college') }}" required="" min="0"/>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Name of Employer<em style="color:red;">{{ $errors->first('employer_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="employer_name" value="{{ old('employer_name', $user->employer_name) }}" required="" />
                        </div>
                        <div class="col-sm-4 text-sm-left">
                            <label class="">Position<em style="color:red;">{{ $errors->first('position') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="position" value="{{ old('position', $user->job_title) }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Address<em style="color:red;">{{ $errors->first('employer_address') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="employer_address" value="{{ old('employer_address') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Tel. No.<em style="color:red;">{{ $errors->first('employer_contact') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="employer_contact" value="{{ old('employer_contact') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Salary<em style="color:red;">{{ $errors->first('salary') }}</em></label>
                            <input type="number" step="any" class="form-control"  name="salary" value="{{ old('salary') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Employment Status<em style="color:red;">{{ $errors->first('employment_status') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="employment_status" value="{{ old('employment_status') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">No. of Years in the company<em style="color:red;">{{ $errors->first('no_of_yrs_company') }}</em></label>
                            <input type="number" step="any" class="form-control"  name="no_of_yrs_company" value="{{ old('no_of_yrs_company') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Father’s Name<em style="color:red;">{{ $errors->first('fathers_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="fathers_name" value="{{ old('fathers_name') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Address<em style="color:red;">{{ $errors->first('fathers_address') }}</em></label>
                            <input input type="text" max="255" class="form-control"  name="fathers_address" value="{{ old('fathers_address') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Tel. No./ Cell No.<em style="color:red;">{{ $errors->first('fathers_contact') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="fathers_contact" value="{{ old('fathers_contact') }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Mother’s Name<em style="color:red;">{{ $errors->first('mothers_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="mothers_name" value="{{ old('mothers_name') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Address<em style="color:red;">{{ $errors->first('mothers_address') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="mothers_address" value="{{ old('mothers_address') }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Tel. No./ Cell No.<em style="color:red;">{{ $errors->first('mothers_contact') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="mothers_contact" value="{{ old('mothers_contact') }}" required="" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Business Data</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Nature of Business<em style="color:red;">{{ $errors->first('business_nature') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="business_nature" value="{{ old('business_nature') }}" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Monthly Income<em style="color:red;">{{ $errors->first('monthly_income') }}</em></label>
                            <input type="number" step="any" class="form-control"  name="monthly_income" value="{{ old('monthly_income') }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Present Address<em style="color:red;">{{ $errors->first('business_address') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="business_address" value="{{ old('business_address') }}" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">No. of Years in the business<em style="color:red;">{{ $errors->first('yrs_in_business') }}</em></label>
                            <input type="number" step="any" class="form-control"  name="yrs_in_business" value="{{ old('yrs_in_business') }}" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col text-sm-left">
                            <strong class="h5">Data on Spouse</strong>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Name of Spouse<em style="color:red;">{{ $errors->first('spouse_name') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="spouse_name" value="{{ old('spouse_name') }}" />
                        </div>
                        <div class="col text-sm-left">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8 text-sm-left">
                            <label class="">Name of Employer<em style="color:red;">{{ $errors->first('spouse_employer') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="spouse_employer" value="{{ old('spouse_employer') }}"/>
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Tel No./ Cell No.<em style="color:red;">{{ $errors->first('spouse_employer_contact') }}</em></label>
                            <input type="text" max="255" class="form-control"  name="spouse_employer_contact" value="{{ old('spouse_employer_contact') }}" />
                        </div>
                    </div>
                    <div class="row p-5">
                        <div class="offset-2 col-sm-8">
                            <h4 class="h5 mb-3"><strong>CONFORME</strong></h4>
                            <p>I warrant the truth and veracity of all the data, information furnished herein to the best of my knowledge. Any undeclared that will be discovered during credit investigation will automatically cause the disapproval of this loan. I expressly submit to any credit investigation as well as to furnish any other requirements of the cooperative by reason hereof.</p>
                        </div>
                    </div>
                    <div class="row py-3 my-5">
                        <div class="col"></div>
                        <div class="col-sm-4">
                            <div><hr class="border-dark mt-5 mb-0"></div>
                            <span>Application’s Signature</span>
                        </div>
                        <div class="col-sm-4">
                            <div><hr class="border-dark mt-5 mb-0"></div>
                            <span>Spouse Name & Signature ( Maker )</span>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row py-3 my-5">
                        <div class="col"></div>
                        <div class="col-sm-4">
                            <div><hr class="border-dark mt-5 mb-0"></div>
                            <span>Signature over printed name ( Co-Maker )</span>
                        </div>
                        <div class="col-sm-4">
                            <div><hr class="border-dark mt-5 mb-0"></div>
                            <span>Signature over printed name ( Co-Maker )</span>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
                <div class="py-3 text-center">
                    <div class="form-group">
                        {{ Form::button('Apply', [
                                'type'=>'submit',
                                'value'=>'Apply',
                                'class'=>'btn rounded-0 orange bg'
                            ]) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop