@extends('layouts.master')

@section('content')
{{-- Branch Side --}}
{{-- Add new Branch --}}
<div class="col-md-6">
    <div class="panel panel-theme rounded shadow">
        <div class="panel-heading">
            <div>
                <h3 class="panel-title">Branch</h3>
            </div>
            {{-- <div class="pull-right">
                <button class="btn btn-sm"
                 data-action="collapse" 
                 data-container="body" 
                 data-toggle="tooltip"
                  data-placement="top" 
                  data-title="Collapse" 
                  data-original-title="" 
                  title="">
                    <i class="fa fa-angle-up">
                        </i>
                    </button>
            </div>
            <div class="clearfix"></div> --}}
        </div>
        <div class="panel-body no-padding">
            @if(session()->has('status'))
                <div class="a-ma3 alert @if(session('status') == 'success') alert-success @elseif(session('status') == 'error') alert-danger @else  @endif branch_message">
                    @if(session()->has('message'))
                        {{ session('message') }}
                    @endif
                </div>
            @endif
            {{ Form::open([
                'url' => 'admin/company/new-branch',
                'method' => 'POST',
                'class' => 'form-horizontal'
                ]) }}
                <div class="form-body">
                    <div class="form-group">
                        {{ validationError($errors, 'branch_name') }}
                        <label>Branch Name</label>
                        {{ Form::text(
                            'branch_name', 
                            old('branch_name'), 
                            [
                                'class' => 'form-control', 
                                'placeholder' => 'Branch Name'
                            ]) 
                        }}
                    </div>
                    <div class="form-group">
                        {{ validationError($errors, 'branch_address') }}
                        <label>Branch Address</label>
                        {{ Form::text(
                            'branch_address', 
                            old('branch_address'),
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Branch Address'
                            ]) 
                        }}
                    </div>
                    <div class="form-group">
                        {{ validationError($errors, 'branch_phone_one') }}
                        <label>Branch Tel/Phone no.</label>
                        <div class="row row_phone_number mb-5">
                            <div class="col-md-4 mb-5">
                                {{ Form::text(
                                    'branch_phone_one',
                                    old('branch_phone_one'), 
                                    [
                                        'class' => 'form-control phone_number',
                                        'placeholder' => 'No.'
                                    ]
                                    )
                                }}
                            </div>
                            <div class="col-md-4 mb-5">
                                {{ Form::text(
                                    'branch_phone_two',
                                    old('branch_phone_two'), 
                                    [
                                        'class' => 'form-control phone_number',
                                        'placeholder' => 'No.'
                                    ]
                                    )
                                }}
                            </div>
                        </div>
                        {{-- <button class="btn btn-sm btn-success mt-2" id="new_branch_phone_no">
                            +
                        </button> --}}
                    </div>
                    <div class="form-group">
                        <label>Branch Type</label>
                        {{ Form::select('branch_type', ['not_main' => 'Not Main Branch', 'main' => 'Main Branch'], 'not_main', ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-footer">
                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
{{-- Add new Teller --}}
{{-- Teller Side --}}
<div class="col-md-6">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div>
                    <h3 class="panel-title">New Teller Account</h3>
                </div>
            </div>
            <div class="panel-body no-padding">
                @if(session()->has('teller_status'))
                    <div class="a-ma3 alert @if(session('teller_status') == 'success') alert-success @elseif(session('teller_status') == 'error') alert-danger @else  @endif branch_message">
                        @if(session()->has('teller_message'))
                            {{ session('teller_message') }}
                        @endif
                    </div>
                @endif
                {{ Form::open([
                    'url' => 'admin/company/new-teller',
                    'method' => 'POST',
                    'class' => 'form-horizontal',
                    'files' => true
                    ]) }}
                    <div class="form-body">
                        {{-- name detailse --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    {{ validationError($errors, 'teller_first_name') }}
                                    <label>First Name</label>
                                    {{ Form::text('teller_first_name',
                                        old('teller_first_name'),
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => 'First Name ex. CPMPC'
                                        ]) 
                                     }}
                                </div>
                                <div class="col-md-4">
                                    {{ validationError($errors, 'teller_midlle_name') }}
                                    <label>Middle Name</label>
                                    {{ Form::text('teller_middle_name',
                                        old('teller_middle_name'),
                                        [
                                            'class' => 'form-control',
                                            'disabled' => 'disabled',
                                            'placeholder' => 'CPMPC'
                                        ]) 
                                        }}
                                </div>
                                <div class="col-md-4">
                                    {{ validationError($errors, 'teller_last_name') }}
                                    <label>Last Name</label>
                                    {{ Form::text('teller_last_name',
                                        old('teller_last_name'),
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => 'Last Name ex. Head Office'
                                        ]) 
                                        }}
                                </div>
                            </div>
                        </div>
                        {{-- username --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_username') }}
                            <label>Username</label>
                            {{ Form::text('teller_username', old('teller_username'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'ex. branch13'
                                ])
                            }}
                        </div>
                        {{-- password --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_password') }}
                            <label>Password</label>
                            {{ Form::password('teller_password',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Password'        
                                ]) 
                            }}
                        </div>
                        {{-- password confirmation --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_password_confirmation') }}
                            <label>Password Confirmation</label>
                            {{ Form::password('teller_password_confirmation',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Password'
                                ])
                            }}
                        </div>
                        {{-- email --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_email') }}
                            <label>Email</label>
                            {{
                                Form::email('teller_email', old('teller_email'),
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'example@gmail.com'
                                ])
                            }}
                        </div>
                        {{-- Bank Name --}}
                        {{-- Account Name --}}
                        {{-- Account Number --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                        <label>Bank Name</label>
                                    {{
                                        Form::text('teller_bank_name', 'BNK002', [
                                            'class' => 'form-control',
                                            'disabled' => 'disabled'
                                        ])
                                    }}
                                </div>
                                <div class="col-md-4">
                                    <label>Account Name</label>
                                    {{
                                        Form::text('teller_account_name', 'ACCT002', [
                                            'class' => 'form-control',
                                            'disabled' => 'disabled'
                                        ])
                                    }}
                                </div>
                                <div class="col-md-4">
                                    <label>Account Number</label>
                                    {{
                                        Form::text('teller_account_number', '0000002', [
                                            'class' => 'form-control',
                                            'disabled' => 'disabled'
                                        ])
                                    }}
                                </div>
                            </div>
                        </div>
                        {{-- Branches --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_branch') }}
                            <label>Branch</label>
                            <select class="form-control" name="teller_branch">
                                <option selected disabled style="display: none">Select a branch...</option>
                                @foreach($branches as $branch)
                                    <option @if(session()->has('teller_branch_id') && $branch->id == session('teller_branch_id')) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Image Upload --}}
                        <div class="form-group">
                            {{ validationError($errors, 'teller_image') }}
                            <div class="uploader">

                                <input id="file-upload" type="file" name="teller_image" accept="image/*" />
                                <label for="file-upload" id="file-drag">
                                    <img id="file-image" src="https://via.placeholder.com/150" alt="preview" >
                                    <div id="start">
                                        {{-- <i class="fa fa-download" aria-hidden="true"></i>
                                            <div>
                                                Select an image
                                            </div> --}}
                                    {{-- <div id="notimage" class="hidden">Please select an image</div> --}}
                                        <span id="file-upload-btn" class="btn btn-primary">Select an image</span>
                                    </div>
                                    {{-- <div id="response" class="hidden">
                                        <div id="messages"></div>
                                        <progress class="progress" id="file-progress" value="0">
                                            <span>0</span>%
                                        </progress>
                                    </div> --}}
                                </label>
                            </div>
                        </div>
                    <div class="form-footer">
                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

<style>
    /* margings */
    .mt-2{
        margin-top: 2px;
    }

    .a-ma3{
        margin: 3px;
    }

    /* File Upload */
    /* Image */
    .uploader {
        display: block;
        clear: both;
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
    }
    .uploader label {
        float: left;
        clear: both;
        width: 100%;
        padding: 2rem 1.5rem;
        text-align: center;
        background: #fff;
        border-radius: 7px;
        border: 3px solid #eee;
        transition: all .2s ease;
        -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
                user-select: none;
    }
    .uploader label:hover {
        border-color: #454cad;
    }
    .uploader label.hover {
        border: 3px solid #454cad;
        box-shadow: inset 0 0 0 6px #eee;
    }
    .uploader label.hover #start i.fa {
        -webkit-transform: scale(0.8);
                transform: scale(0.8);
        opacity: 0.3;
    }
    .uploader #start {
        float: left;
        clear: both;
        width: 100%;
    }
    .uploader #start.hidden {
        display: none;
    }
    .uploader #start i.fa {
        font-size: 50px;
        margin-bottom: 1rem;
        transition: all .2s ease-in-out;
    }
    .uploader #response {
        float: left;
        clear: both;
        width: 100%;
    }
    .uploader #response.hidden {
        display: none;
    }
    .uploader #response #messages {
        margin-bottom: .5rem;
    }
    .uploader #file-image {
        display: inline;
        margin: 0 auto .5rem auto;
        width: auto;
        height: auto;
        max-width: 180px;
    }
    .uploader #file-image.hidden {
        display: none;
    }
    .uploader #notimage {
        display: block;
        float: left;
        clear: both;
        width: 100%;
    }
    .uploader #notimage.hidden {
        display: none;
    }
    .uploader progress,
    .uploader .progress {
        display: inline;
        clear: both;
        margin: 0 auto;
        width: 100%;
        max-width: 180px;
        height: 8px;
        border: 0;
        border-radius: 4px;
        background-color: #eee;
        overflow: hidden;
    }
    .uploader .progress[value]::-webkit-progress-bar {
        border-radius: 4px;
        background-color: #eee;
    }
    .uploader .progress[value]::-webkit-progress-value {
        background: linear-gradient(to right, #393f90 0%, #454cad 50%);
        border-radius: 4px;
    }
    .uploader .progress[value]::-moz-progress-bar {
        background: linear-gradient(to right, #393f90 0%, #454cad 50%);
        border-radius: 4px;
    }
    .uploader input[type="file"] {
        display: none;
    }
    .uploader div {
        margin: 0 0 .5rem 0;
        color: #5f6982;
    }
    .uploader .btn {
        display: inline-block;
        margin: .5rem .5rem 1rem .5rem;
        clear: both;
        font-family: inherit;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        text-transform: initial;
        border: none;
        border-radius: .2rem;
        outline: none;
        padding: 0 1rem;
        height: 36px;
        line-height: 36px;
        color: #fff;
        transition: all 0.2s ease-in-out;
        box-sizing: border-box;
        background: #454cad;
        border-color: #454cad;
        cursor: pointer;
    }


</style>

<script>

    var phone_no = $('#new_branch_phone_no');
    var branch_alert = $('.branch_message');
    $(document).ready(function(){

        // setTimeout(function(){
        //     branch_alert.addClass('hide');
        // }, 3000);

        $('.phone_number').keyup(function(e){
            // $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
            let key = e.charCode || e.keyCode || 0;
            let text = $(this); 
            if (key !== 8 && key !== 9) {
                if (text.val().length === 3) {
                    text.val(text.val() + '-');
                }
            }

            return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
        });


        // when + button is click
        phone_no.click(function(e){
            e.preventDefault();

            let last_row = $('.row_phone_number');

            if(last_row.children().length < 6){
                last_row.last().append(NewBranchPhoneNumber());
            } 

        });

        // file upload
        $('#file-upload').change(function(){
            previewImage(this);
        });

    });

    function NewBranchPhoneNumber()
    {
        let html = '<div class="col-md-4 mb-5">';
        html += '{{ Form::number("branch_phone_no", old("branch_phone_no"), ["class" => "form-control", "placeholder" => "No."] )}}';
        html += '</div>';

        return html;
    }

    function previewImage(e)
    {
        if(e.files && e.files[0]){
            let reader = new FileReader();

            reader.onload = function(e){
                document.getElementById('file-image').src = e.target.result;
            }

            reader.readAsDataURL(e.files[0]);
        }
    }


    // File Upload
    //
    // function ekUpload() {
    //     function Init() {
    //         console.log("Upload Initialised");

    //         var fileSelect = document.getElementById("file-upload");
    //         // fileDrag = document.getElementById("file-drag"),
    //         // submitButton = document.getElementById("submit-button");

    //         fileSelect.addEventListener("change", fileSelectHandler, false);

    //         // Is XHR2 available?
    //         // var xhr = new XMLHttpRequest();
    //         // if (xhr.upload) {
    //         // // File Drop
    //         // fileDrag.addEventListener("dragover", fileDragHover, false);
    //         // fileDrag.addEventListener("dragleave", fileDragHover, false);
    //         // fileDrag.addEventListener("drop", fileSelectHandler, false);
    //     }
    // }

    // // function fileDragHover(e) {
    // //     var fileDrag = document.getElementById("file-drag");

    // //     e.stopPropagation();
    // //     e.preventDefault();

    // //     fileDrag.className =
    // //     e.type === "dragover" ? "hover" : "modal-body file-upload";
    // // }

    // function fileSelectHandler(e) {
    //     // Fetch FileList object
    //     // var files = e.target.files || e.dataTransfer.files;

    //     // // Cancel event and hover styling
    //     // fileDragHover(e);

    //     // // Process all File objects
    //     // for (var i = 0, f; (f = files[i]); i++) {
    //     //     parseFile(f);
    //     //     uploadFile(f);
    //     // }

    //     let reader = new FileReader();

    //     reader.onload = function(){
    //         let output = document.getElementById('file-image');
    //         output.src = reader.result;
    //     }

    //     reader.readAsDataURL(e.target.files[0]);



    // }

    // // // Output
    // // function output(msg) {
    // //     // Response
    // //     var m = document.getElementById("messages");
    // //     m.innerHTML = msg;
    // // }

    // // function parseFile(file) {
    // //     console.log(file.name);
    // //     output("<strong>" + encodeURI(file.name) + "</strong>");

    // //     // var fileType = file.type;
    // //     // console.log(fileType);
    // //     var imageName = file.name;

    // //     var isGood = /\.(?=gif|jpg|png|jpeg)/gi.test(imageName);
    // //     if (isGood) {
    // //         document.getElementById("start").classList.add("hidden");
    // //         document.getElementById("response").classList.remove("hidden");
    // //         document.getElementById("notimage").classList.add("hidden");
    // //         // Thumbnail Preview
    // //         document.getElementById("file-image").classList.remove("hidden");
    // //         document.getElementById("file-image").src = URL.createObjectURL(file);
    // //     } else {
    // //         document.getElementById("file-image").classList.add("hidden");
    // //         document.getElementById("notimage").classList.remove("hidden");
    // //         document.getElementById("start").classList.remove("hidden");
    // //         document.getElementById("response").classList.add("hidden");
    // //         document.getElementById("file-upload-form").reset();
    // //     }
    // // }

    // // function setProgressMaxValue(e) {
    // //     var pBar = document.getElementById("file-progress");

    // //     if (e.lengthComputable) {
    // //         pBar.max = e.total;
    // //     }
    // // }

    // // function updateFileProgress(e) {
    // //     var pBar = document.getElementById("file-progress");

    // //     if (e.lengthComputable) {
    // //         pBar.value = e.loaded;
    // //     }
    // // }

    // // function uploadFile(file) {
    // //     var xhr = new XMLHttpRequest(),
    // //         fileInput = document.getElementById("class-roster-file"),
    // //         pBar = document.getElementById("file-progress"),
    // //         fileSizeLimit = 1024; // In MB
    // //     if (xhr.upload) {
    // //     // Check if file is less than x MB
    // //     if (file.size <= fileSizeLimit * 1024 * 1024) {
    // //         // Progress bar
    // //         pBar.style.display = "inline";
    // //         xhr.upload.addEventListener("loadstart", setProgressMaxValue, false);
    // //         xhr.upload.addEventListener("progress", updateFileProgress, false);

    // //         // File received / failed
    // //         xhr.onreadystatechange = function(e) {
    // //         if (xhr.readyState == 4) {
    // //             // Everything is good!
    // //             // progress.className = (xhr.status == 200 ? "success" : "failure");
    // //             // document.location.reload(true);
    // //         }
    // //         };

    // //         // Start upload
    // //         xhr.open(
    // //         "POST",
    // //         document.getElementById("file-upload-form").action,
    // //         true
    // //         );
    // //         xhr.setRequestHeader("X-File-Name", file.name);
    // //         xhr.setRequestHeader("X-File-Size", file.size);
    // //         xhr.setRequestHeader("Content-Type", "multipart/form-data");
    // //         xhr.send(file);
    // //     } else {
    // //         output("Please upload a smaller file (< " + fileSizeLimit + " MB).");
    // //     }
    // //     }
    // // }

    // //     // Check for the various File API support.
    // //     if (window.File && window.FileList && window.FileReader) {
    // //         Init();
    // //     } else {
    // //         document.getElementById("file-drag").style.display = "none";
    // //     }
    // // }
    // ekUpload();


</script>

@stop