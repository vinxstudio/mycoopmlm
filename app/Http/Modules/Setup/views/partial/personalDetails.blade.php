<h4 class="mt-30">Personal details</h4>
<div class="form-group">
    <div class="input-icon mb-15">
        {{ validationError($errors, 'firstName') }}
        <i class="fa fa-user"></i>
        <input class="form-control" placeholder="First Name" value="{{ old('firstName') }}" name="firstName" id="firstName" type="text">
    </div>
</div>
<div class="form-group">
    <div class="input-icon">
        {{ validationError($errors, 'lastName') }}
        <i class="fa fa-user"></i>
        <input class="form-control" placeholder="Last Name" id="lastName" value="{{ old('lastName') }}" name="lastName" type="text">
    </div>
</div>
<div class="form-group">
    <div class="input-icon">
        {{ validationError($errors, 'username') }}
        <i class="fa fa-envelope"></i>
        <input class="form-control" name="username" id="username" value="{{ old('username') }}" placeholder="Email / Username" type="text">
    </div>
</div>
<div class="form-group">
    <div class="input-icon">
        {{ validationError($errors, 'password') }}
        <i class="fa fa-lock"></i>
        <input class="form-control" placeholder="Password" name="password" type="password">
    </div>
</div>
<a href="#" class="next-step pull-right btn btn-primary" data-target="#tab1-2">Next <i class="fa fa-arrow-right"></i></a>