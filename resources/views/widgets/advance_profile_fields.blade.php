<div class="clearfix"></div>
<div class="col-md-12"><legend>USER INFO</legend></div>
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 form-group">
    {{ validationError($errors, 'coop_id') }}
   <label class="control-label">Members Coop Id.</label>
   <input type="text" name="coop_id" placeholder="{{ Lang::get('members.coop_id') }}" value="{{ old('coop_id', isset($user->details->coop_id) ? $user->details->coop_id : null ) }}" class="form-control" readonly>
</div>
<div class="col-md-1 col-sm-12 form-group">
     {{ validationError($errors, 'title') }}
    <label class="control-label">{{ Lang::get('members.title') }}</label>
    <input type="text" name="title" placeholder="{{ Lang::get('members.title') }}" value="{{ old('title', isset($user->details->title) ? $user->details->title : null ) }}" class="form-control" readonly>
</div>
<div class="col-md-3 col-sm-12 form-group">
     {{ validationError($errors, 'first_name') }}
    <label class="control-label">{{ Lang::get('members.first_name') }}</label>
    <input type="text" name="first_name" placeholder="{{ Lang::get('members.first_name') }}" value="{{ old('first_name', isset($user->details->first_name) ? $user->details->first_name : null ) }}" class="form-control" readonly>
</div>
<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'last_name') }}
    <label class="control-label">{{ Lang::get('members.last_name') }}</label>
    <input type="text" name="last_name" placeholder="{{ Lang::get('members.last_name') }}" value="{{ old('last_name', isset($user->details->last_name) ? $user->details->last_name : null) }}" class="form-control" readonly>
</div>

<div class="col-md-3 col-sm-12 form-group">
     {{ validationError($errors, 'email') }}
    <label class="control-label">{{ Lang::get('members.middle_name') }}</label>
    <input type="text" name="middle_name" placeholder="{{ Lang::get('members.middle_name') }}" value="{{ old('middle_name', isset($user->details->middle_name) ? $user->details->middle_name : null) }}" class="form-control" readonly>
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'suffix') }}
    <label class="control-label">{{ Lang::get('members.suffix') }}</label>
    <input type="text" name="suffix" placeholder="{{ Lang::get('members.suffix') }}" value="{{ old('suffix', isset($user->details->suffix) ? $user->details->suffix : null) }}" class="form-control" readonly>
</div>

<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'birth_date') }}
    <label class="control-label">{{ Lang::get('members.birth_date') }}</label>
    <input type="text" name="birth_date" placeholder="{{ Lang::get('members.birth_date') }}" value="{{ old('birth_date', isset($user->details->birth_date) ? $user->details->birth_date : '0000-00-00') }}" class="form-control">
</div>
<div class="col-md-6 col-sm-12 form-group">
    {{ validationError($errors, 'birth_place') }}
    <label class="control-label">{{ Lang::get('members.birth_place') }}</label>
    <input type="text" name="birth_place" placeholder="{{ Lang::get('members.birth_place') }}" value="{{ old('birth_place', isset($user->details->birth_place) ? $user->details->birth_place : null) }}" class="form-control">
</div>
<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'profession') }}
    <label class="control-label">{{ Lang::get('members.profession') }}</label>
    <input type="text" name="profession" placeholder="{{ Lang::get('members.profession') }}" value="{{ old('profession', isset($user->details->profession) ? $user->details->profession : null) }}" class="form-control">
</div>

<div class="clearfix"></div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'gender') }}
    <label class="control-label">{{ Lang::get('members.gender') }}</label>
    <input type="text" name="gender" placeholder="{{ Lang::get('members.gender') }}" value="{{ old('gender', isset($user->details->gender) ? $user->details->gender : null) }}" class="form-control">
</div>
<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'religion') }}
    <label class="control-label">{{ Lang::get('members.religion') }}</label>
    <input type="text" name="religion" placeholder="{{ Lang::get('members.religion') }}" value="{{ old('religion', isset($user->details->religion) ? $user->details->religion : null) }}" class="form-control">
</div>
<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'nationality') }}
    <label class="control-label">{{ Lang::get('members.nationality') }}</label>
    <input type="text" name="nationality" placeholder="{{ Lang::get('members.nationality') }}" value="{{ old('nationality', isset($user->details->nationality) ? $user->details->nationality : null) }}" class="form-control">
</div>
<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'no_dependents') }}
    <label class="control-label">{{ Lang::get('members.no_dependents') }}</label>
    <input type="text" name="no_dependents" placeholder="{{ Lang::get('members.no_dependents') }}" value="{{ old('no_dependents', isset($user->details->no_dependents) ? $user->details->no_dependents : 0) }}" class="form-control">
</div>
<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'height') }}
    <label class="control-label">{{ Lang::get('members.height') }}</label>
    <input type="text" name="height" placeholder="{{ Lang::get('members.height') }}" value="{{ old('height', isset($user->details->height) ? $user->details->height : 0) }}" class="form-control">
</div>
<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'weight') }}
    <label class="control-label">{{ Lang::get('members.weight') }}</label>
    <input type="text" name="weight" placeholder="{{ Lang::get('members.weight') }}" value="{{ old('weight', isset($user->details->weight) ? $user->details->weight : 0) }}" class="form-control">
</div>

<div class="clearfix"></div>
<div class="col-md-12"><legend>ADDRESS</legend></div>
<div class="clearfix"></div>

<!-- present address start -->
<label>Present Address (Mailing Address)</label>
<div class="clearfix"></div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'present_street') }}
    <label class="control-label">{{ Lang::get('members.street') }}</label>
    <input type="text" name="present_street" placeholder="{{ Lang::get('members.street') }}" value="{{ old('present_street', isset($user->details->present_street) ? $user->details->present_street : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'present_barangay') }}
    <label class="control-label">{{ Lang::get('members.barangay') }}</label>
    <input type="text" name="present_barangay" placeholder="{{ Lang::get('members.barangay') }}" value="{{ old('present_barangay', isset($user->details->present_barangay) ? $user->details->present_barangay : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'present_town') }}
    <label class="control-label">{{ Lang::get('members.town') }}</label>
    <input type="text" name="present_town" placeholder="{{ Lang::get('members.town') }}" value="{{ old('present_town', isset($user->details->present_town) ? $user->details->present_town : null) }}" class="form-control">
</div>

<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'present_city') }}
    <label class="control-label">{{ Lang::get('members.city') }}</label>
    <input type="text" name="present_city" placeholder="{{ Lang::get('members.city') }}" value="{{ old('present_city', isset($user->details->present_city) ? $user->details->present_city : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'present_province') }}
    <label class="control-label">{{ Lang::get('members.province') }}</label>
    <input type="text" name="present_province" placeholder="{{ Lang::get('members.province') }}" value="{{ old('present_province', isset($user->details->present_province) ? $user->details->present_province : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'present_since') }}
    <label class="control-label">{{ Lang::get('members.since') }}</label>
    <input type="text" name="present_since" placeholder="{{ Lang::get('members.since') }}" value="{{ old('present_since', isset($user->details->present_since) ? $user->details->present_since : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'present_zipcode') }}
    <label class="control-label">{{ Lang::get('members.zipcode') }}</label>
    <input type="text" name="present_zipcode" placeholder="{{ Lang::get('members.zipcode') }}" value="{{ old('present_zipcode', isset($user->details->present_zipcode) ? $user->details->present_zipcode : null) }}" class="form-control">
</div>
<!-- present address end -->

<!-- provincial address start -->
<label>Provincial Address</label>
<div class="clearfix"></div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_street') }}
    <label class="control-label">{{ Lang::get('members.street') }}</label>
    <input type="text" name="provincial_street" placeholder="{{ Lang::get('members.street') }}" value="{{ old('provincial_street', isset($user->details->provincial_street) ? $user->details->provincial_street : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_barangay') }}
    <label class="control-label">{{ Lang::get('members.barangay') }}</label>
    <input type="text" name="provincial_barangay" placeholder="{{ Lang::get('members.barangay') }}" value="{{ old('provincial_barangay', isset($user->details->provincial_barangay) ? $user->details->provincial_barangay : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_town') }}
    <label class="control-label">{{ Lang::get('members.town') }}</label>
    <input type="text" name="provincial_town" placeholder="{{ Lang::get('members.town') }}" value="{{ old('provincial_town', isset($user->details->provincial_town) ? $user->details->provincial_town : null) }}" class="form-control">
</div>

<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_city') }}
    <label class="control-label">{{ Lang::get('members.city') }}</label>
    <input type="text" name="provincial_city" placeholder="{{ Lang::get('members.city') }}" value="{{ old('provincial_city', isset($user->details->provincial_city) ? $user->details->provincial_city : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_province') }}
    <label class="control-label">{{ Lang::get('members.province') }}</label>
    <input type="text" name="provincial_province" placeholder="{{ Lang::get('members.province') }}" value="{{ old('provincial_province', isset($user->details->provincial_province) ? $user->details->provincial_province : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_since') }}
    <label class="control-label">{{ Lang::get('members.since') }}</label>
    <input type="text" name="provincial_since" placeholder="{{ Lang::get('members.since') }}" value="{{ old('provincial_since', isset($user->details->provincial_since) ? $user->details->provincial_since : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'provincial_zipcode') }}
    <label class="control-label">{{ Lang::get('members.zipcode') }}</label>
    <input type="text" name="provincial_zipcode" placeholder="{{ Lang::get('members.zipcode') }}" value="{{ old('provincial_zipcode', isset($user->details->provincial_zipcode) ? $user->details->provincial_zipcode : null) }}" class="form-control">
</div>
<!-- present address end -->

<!-- Start Employment -->
<div class="clearfix"></div>
<div class="col-md-12"><legend>EMPLOYMENT</legend></div>
<div class="clearfix"></div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'employer_name') }}
    <label class="control-label">{{ Lang::get('members.employer_name') }}</label>
    <input type="text" name="employer_name" placeholder="{{ Lang::get('members.employer_name') }}" value="{{ old('proviemployer_namecial_zipcode', isset($user->details->employer_name) ? $user->details->employer_name : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'job_title') }}
    <label class="control-label">{{ Lang::get('members.job_title') }}</label>
    <input type="text" name="job_title" placeholder="{{ Lang::get('members.job_title') }}" value="{{ old('job_title', isset($user->details->job_title) ? $user->details->job_title : null) }}" class="form-control">
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'date_hired') }}
    <label class="control-label">{{ Lang::get('members.date_hired') }}</label>
    <input type="text" name="date_hired" placeholder="{{ Lang::get('members.date_hired') }}" value="{{ old('date_hired', isset($user->details->date_hired) ? $user->details->date_hired : '0000-00-00') }}" class="form-control">
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'job_status') }}
    <label class="control-label">{{ Lang::get('members.job_status') }}</label>
    <input type="text" name="job_status" placeholder="{{ Lang::get('members.job_status') }}" value="{{ old('job_status', isset($user->details->job_status) ? $user->details->job_status : null) }}" class="form-control">
</div>

<!-- End Employment -->
<!-- Start Education -->
<div class="clearfix"></div>
<div class="col-md-12"><legend>EDUCATION</legend></div>
<div class="clearfix"></div>

<div class="col-md-5 col-sm-12 form-group">
    {{ validationError($errors, 'educational_attainment') }}
    <label class="control-label">{{ Lang::get('members.educational_attainment') }}</label>
    <input type="text" name="educational_attainment" placeholder="{{ Lang::get('members.educational_attainment') }}" value="{{ old('educational_attainment', isset($user->details->educational_attainment) ? $user->details->educational_attainment : null) }}" class="form-control">
</div>

<div class="col-md-5 col-sm-12 form-group">
    {{ validationError($errors, 'school_last_attended') }}
    <label class="control-label">{{ Lang::get('members.school_last_attended') }}</label>
    <input type="text" name="school_last_attended" placeholder="{{ Lang::get('members.school_last_attended') }}" value="{{ old('school_last_attended', isset($user->details->school_last_attended) ? $user->details->school_last_attended : null) }}" class="form-control">
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'education_year') }}
    <label class="control-label">{{ Lang::get('members.year') }}</label>
    <input type="text" name="education_year" placeholder="{{ Lang::get('members.year') }}" value="{{ old('education_year', isset($user->details->education_year) ? $user->details->education_year : null) }}" class="form-control">
</div>

<!-- End Education -->

<!-- Start Contact Number -->

<div class="clearfix"></div>
<div class="col-md-12"><legend>CONTACT NUMBER</legend></div>
<label>(No dash (-) or slash(/))</label>
<div class="clearfix"></div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'cellphone_no') }}
    <label class="control-label">{{ Lang::get('members.cellphone_no') }}</label>
    <input type="text" name="cellphone_no" placeholder="{{ Lang::get('members.cellphone_no') }}" value="{{ old('cellphone_no', isset($user->details->cellphone_no) ? $user->details->cellphone_no : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'email') }}
    <label class="control-label">{{ Lang::get('members.email') }}</label>
    <input type="text" name="email" placeholder="{{ Lang::get('members.email') }}" value="{{ old('email', isset($user->details->email) ? $user->details->email : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'other_contact_no') }}
    <label class="control-label">{{ Lang::get('members.other_contact_no') }}</label>
    <input type="text" name="other_contact_no" placeholder="{{ Lang::get('members.other_contact_no') }}" value="{{ old('other_contact_no', isset($user->details->other_contact_no) ? $user->details->other_contact_no : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'home_tel_no') }}
    <label class="control-label">{{ Lang::get('members.home_tel_no') }}</label>
    <input type="text" name="home_tel_no" placeholder="{{ Lang::get('members.home_tel_no') }}" value="{{ old('home_tel_no', isset($user->details->home_tel_no) ? $user->details->home_tel_no : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'spouse_tel_no') }}
    <label class="control-label">{{ Lang::get('members.spouse_tel_no') }}</label>
    <input type="text" name="spouse_tel_no" placeholder="{{ Lang::get('members.spouse_tel_no') }}" value="{{ old('spouse_tel_no', isset($user->details->spouse_tel_no) ? $user->details->spouse_tel_no : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'province_tel_no') }}
    <label class="control-label">{{ Lang::get('members.province_tel_no') }}</label>
    <input type="text" name="province_tel_no" placeholder="{{ Lang::get('members.province_tel_no') }}" value="{{ old('province_tel_no', isset($user->details->province_tel_no) ? $user->details->province_tel_no : null) }}" class="form-control">
</div>

<!-- End Contact Number -->

<!-- Start ID  -->
<div class="clearfix"></div>
<div class="col-md-12"><legend>ID</legend></div>
<label>Primary</label>
<div class="clearfix"></div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'tin') }}
    <label class="control-label">{{ Lang::get('members.tin') }}</label>
    <input type="text" name="tin" placeholder="{{ Lang::get('members.tin') }}" value="{{ old('tin', isset($user->details->tin) ? $user->details->tin : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'gsis') }}
    <label class="control-label">{{ Lang::get('members.gsis') }}</label>
    <input type="text" name="gsis" placeholder="{{ Lang::get('members.gsis') }}" value="{{ old('gsis', isset($user->details->gsis) ? $user->details->gsis : null) }}" class="form-control">
</div>

<div class="col-md-4 col-sm-12 form-group">
    {{ validationError($errors, 'sss') }}
    <label class="control-label">{{ Lang::get('members.sss') }}</label>
    <input type="text" name="sss" placeholder="{{ Lang::get('members.sss') }}" value="{{ old('sss', isset($user->details->sss) ? $user->details->sss : null) }}" class="form-control">
</div>
<div class="clearfix"></div>
<label>Secondary</label>
<div class="clearfix"></div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'senior') }}
    <label class="control-label">{{ Lang::get('members.senior') }}</label>
    <input type="text" name="senior" placeholder="{{ Lang::get('members.senior') }}" value="{{ old('senior', isset($user->details->senior) ? $user->details->senior : null) }}" class="form-control">
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'voters') }}
    <label class="control-label">{{ Lang::get('members.voters') }}</label>
    <input type="text" name="voters" placeholder="{{ Lang::get('members.voters') }}" value="{{ old('voters', isset($user->details->voters) ? $user->details->voters : null) }}" class="form-control">
</div>

<div class="col-md-2 col-sm-12 form-group">
    {{ validationError($errors, 'philhealth') }}
    <label class="control-label">{{ Lang::get('members.philhealth') }}</label>
    <input type="text" name="philhealth" placeholder="{{ Lang::get('members.philhealth') }}" value="{{ old('sphilhealthss', isset($user->details->philhealth) ? $user->details->philhealth : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'pagibig') }}
    <label class="control-label">{{ Lang::get('members.pagibig') }}</label>
    <input type="text" name="pagibig" placeholder="{{ Lang::get('members.pagibig') }}" value="{{ old('pagibig', isset($user->details->pagibig) ? $user->details->pagibig : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'drivers_license') }}
    <label class="control-label">{{ Lang::get('members.drivers_license') }}</label>
    <input type="text" name="drivers_license" placeholder="{{ Lang::get('members.drivers_license') }}" value="{{ old('drivers_license', isset($user->details->drivers_license) ? $user->details->drivers_license : null) }}" class="form-control">
</div>
<!-- END ID  -->

<!-- Start SPOUSE INFORMATION -->
<div class="clearfix"></div>
<div class="col-md-12"><legend>SPOUSE INFORMATION</legend></div>
<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_last_name') }}
    <label class="control-label">{{ Lang::get('members.s_last_name') }}</label>
    <input type="text" name="s_last_name" placeholder="{{ Lang::get('members.s_last_name') }}" value="{{ old('s_last_name', isset($user->details->s_last_name) ? $user->details->s_last_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_first_name') }}
    <label class="control-label">{{ Lang::get('members.s_first_name') }}</label>
    <input type="text" name="s_first_name" placeholder="{{ Lang::get('members.s_first_name') }}" value="{{ old('s_first_name', isset($user->details->s_first_name) ? $user->details->s_first_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_middle_name') }}
    <label class="control-label">{{ Lang::get('members.s_middle_name') }}</label>
    <input type="text" name="s_middle_name" placeholder="{{ Lang::get('members.s_middle_name') }}" value="{{ old('s_middle_name', isset($user->details->s_middle_name) ? $user->details->s_middle_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_suffix') }}
    <label class="control-label">{{ Lang::get('members.s_suffix') }}</label>
    <input type="text" name="s_suffix" placeholder="{{ Lang::get('members.s_suffix') }}" value="{{ old('s_suffix', isset($user->details->s_suffix) ? $user->details->s_suffix : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_gender') }}
    <label class="control-label">{{ Lang::get('members.s_gender') }}</label>
    <input type="text" name="s_gender" placeholder="{{ Lang::get('members.s_gender') }}" value="{{ old('s_gender', isset($user->details->s_gender) ? $user->details->s_gender : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 's_birth_date') }}
    <label class="control-label">{{ Lang::get('members.s_birth_date') }}</label>
    <input type="text" name="s_birth_date" placeholder="{{ Lang::get('members.s_birth_date') }}" value="{{ old('s_birth_date', isset($user->details->s_birth_date) ? $user->details->s_birth_date : '0000-00-00') }}" class="form-control">
</div>

<div class="col-md-6 col-sm-12 form-group">
    {{ validationError($errors, 's_occupation') }}
    <label class="control-label">{{ Lang::get('members.s_occupation') }}</label>
    <input type="text" name="s_occupation" placeholder="{{ Lang::get('members.s_occupation') }}" value="{{ old('s_occupation', isset($user->details->s_occupation) ? $user->details->s_occupation : null) }}" class="form-control">
</div>

<div class="col-md-6 col-sm-12 form-group">
    {{ validationError($errors, 's_educational_attainment') }}
    <label class="control-label">{{ Lang::get('members.s_educational_attainment') }}</label>
    <input type="text" name="s_educational_attainment" placeholder="{{ Lang::get('members.s_educational_attainment') }}" value="{{ old('s_educational_attainment', isset($user->details->s_educational_attainment) ? $user->details->s_educational_attainment : null) }}" class="form-control">
</div>

<div class="col-md-6 col-sm-12 form-group">
    {{ validationError($errors, 's_degree') }}
    <label class="control-label">{{ Lang::get('members.s_degree') }}</label>
    <input type="text" name="s_degree" placeholder="{{ Lang::get('members.s_degree') }}" value="{{ old('s_degree', isset($user->details->s_degree) ? $user->details->s_degree : null) }}" class="form-control">
</div>

<!-- End SPOUSE INFORMATION -->

<!-- Start PARENTS INFORMATION -->
<div class="clearfix"></div>
<div class="col-md-12"><legend>PARENTS INFORMATION</legend></div>
<label>Father's Name</label>
<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'f_last_name') }}
    <label class="control-label">{{ Lang::get('members.f_last_name') }}</label>
    <input type="text" name="f_last_name" placeholder="{{ Lang::get('members.f_last_name') }}" value="{{ old('f_last_name', isset($user->details->f_last_name) ? $user->details->f_last_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'f_first_name') }}
    <label class="control-label">{{ Lang::get('members.f_first_name') }}</label>
    <input type="text" name="f_first_name" placeholder="{{ Lang::get('members.f_first_name') }}" value="{{ old('f_first_name', isset($user->details->f_first_name) ? $user->details->f_first_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'f_middle_name') }}
    <label class="control-label">{{ Lang::get('members.f_middle_name') }}</label>
    <input type="text" name="f_middle_name" placeholder="{{ Lang::get('members.f_middle_name') }}" value="{{ old('f_middle_name', isset($user->details->f_middle_name) ? $user->details->f_middle_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'f_suffix') }}
    <label class="control-label">{{ Lang::get('members.f_suffix') }}</label>
    <input type="text" name="f_suffix" placeholder="{{ Lang::get('members.f_suffix') }}" value="{{ old('f_suffix', isset($user->details->f_suffix) ? $user->details->f_suffix : null) }}" class="form-control">
</div>

<div class="clearfix"></div>
<label>Mothers's Maiden Name</label>
<div class="clearfix"></div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'm_last_name') }}
    <label class="control-label">{{ Lang::get('members.m_last_name') }}</label>
    <input type="text" name="m_last_name" placeholder="{{ Lang::get('members.m_last_name') }}" value="{{ old('m_last_name', isset($user->details->m_last_name) ? $user->details->m_last_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'm_first_name') }}
    <label class="control-label">{{ Lang::get('members.m_first_name') }}</label>
    <input type="text" name="m_first_name" placeholder="{{ Lang::get('members.m_first_name') }}" value="{{ old('m_first_name', isset($user->details->m_first_name) ? $user->details->m_first_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'm_middle_name') }}
    <label class="control-label">{{ Lang::get('members.m_middle_name') }}</label>
    <input type="text" name="m_middle_name" placeholder="{{ Lang::get('members.m_middle_name') }}" value="{{ old('m_middle_name', isset($user->details->m_middle_name) ? $user->details->m_middle_name : null) }}" class="form-control">
</div>

<div class="col-md-3 col-sm-12 form-group">
    {{ validationError($errors, 'm_suffix') }}
    <label class="control-label">{{ Lang::get('members.m_suffix') }}</label>
    <input type="text" name="m_suffix" placeholder="{{ Lang::get('members.m_suffix') }}" value="{{ old('m_suffix', isset($user->details->m_suffix) ? $user->details->m_suffix : null) }}" class="form-control">
</div>

<!-- END PARENTS INFORMATION -->
<div class="clearfix"></div>

<div class="col-md-12"><legend>TrueMoney</legend></div>
<div class="clearfix"></div>

<div class="form-group">
    {{ validationError($errors, 'truemoney') }}
    <label class="control-label">{{ Lang::get('members.truemoney') }}</label>
    <input type="text" name="truemoney" placeholder="{{ Lang::get('members.truemoney') }}" value="{{ old('truemoney', isset($user->details->truemoney) ? $user->details->truemoney : null) }}" class="form-control">
</div>

<div class="clearfix"></div>
<div class="col-md-12"><legend>BANK INFORMATION</legend></div>
<div class="clearfix"></div>

<div class="form-group">
    {{ validationError($errors, 'bank_name') }}
    <label class="control-label">{{ Lang::get('members.bank_name') }}</label>
    <input type="text" name="bank_name" placeholder="{{ Lang::get('members.bank_name') }}" value="{{ old('bank_name', isset($user->details->bank_name) ? $user->details->bank_name : null) }}" class="form-control">
</div>
<div class="form-group">
    {{ validationError($errors, 'bank_account_name') }}
    <label class="control-label">{{ Lang::get('members.bank_account_name') }}</label>
    <input type="text" name="bank_account_name" placeholder="{{ Lang::get('members.bank_account_name') }}" value="{{ old('bank_account_name', isset($user->details->account_name) ? $user->details->account_name : null) }}" class="form-control">
</div>
<div class="form-group">
    {{ validationError($errors, 'bank_account_number') }}
    <label class="control-label">{{ Lang::get('members.bank_account_number') }}</label>
    <input type="text" name="bank_account_number" placeholder="{{ Lang::get('members.bank_account_number') }}" value="{{ old('bank_account_number', isset($user->details->account_number) ? $user->details->account_number : null) }}" class="form-control">
</div>
<div class="form-group">
    {{ validationError($errors, 'username') }}
    <label class="control-label">{{ Lang::get('members.username') }}</label>
    <input type="text" name="username" placeholder="{{ Lang::get('members.username') }}" value="{{ old('username', isset($user->username) ? $user->username : null) }}" class="form-control" readonly>
</div>
<div class="form-group">
    {{ validationError($errors, 'password') }}
    <label class="control-label">{{ ($id > 0) ? Lang::get('members.change_password') : Lang::get('members.new_password') }}</label>
    <input type="password" name="password" placeholder="{{ ($id > 0) ? Lang::get('members.change_password') : Lang::get('members.new_password') }}" value="" class="form-control">
</div>
<div class="form-group">
    {{ validationError($errors, 'password_confirm') }}
    <label class="control-label">{{ Lang::get('members.confirm_new_password') }}</label>
    <input type="password" name="password_confirm" placeholder="{{ Lang::get('members.confirm_new_password') }}" value="" class="form-control">
</div>