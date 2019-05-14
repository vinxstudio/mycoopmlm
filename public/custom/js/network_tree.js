  const base_url = window.location.origin;
  const region_url =  base_url+'/public/philippines/refregion.json';
  const province_url =  base_url+'/public/philippines/refprovince.json';
  const citymun_url =  base_url+'/public/philippines/refcitymun.json';
  const brgy_url =  base_url+'/public/philippines/refbrgy.json';

  var region_data;
  var province_data;
  var citymun_data;
  var brgy_data;

  let select_region = $('.region');
  let present_province = $('#present_province');
  let present_citymun = $('#present_city_mun');
  let present_barangay = $('#present_barangay');

  let provincial_province = $('#provincial_province');
  let provincial_citymun = $('#provincial_city_mun');
  let provincial_barangay = $('#provincial_barangay');

  function loadRegion()
  {
     $.ajax({
        type: 'GET',
        url: region_url,
        dataType: 'json',
        async: false,
        success: function(data) {
          region_data = data.RECORDS;
        }
    });
  }

  function loadProvince()
  {
     $.ajax({
        type: 'GET',
        url: province_url,
        dataType: 'json',
        async: false,
        success: function(data) {
          province_data = data.RECORDS;
        }
    });
  }
  
  function loadCitymun()
  {
     $.ajax({
        type: 'GET',
        url: citymun_url,
        dataType: 'json',
        async: false,
        success: function(data) {
          citymun_data = data.RECORDS;
        }
    });
  }

  function loadBrgy()
  {
     $.ajax({
        type: 'GET',
        url: brgy_url,
        dataType: 'json',
        async: false,
        success: function(data) {
          brgy_data = data.RECORDS;
        }
    });
  }
  
  loadRegion();
  loadProvince();
  loadCitymun();
  loadBrgy();
  
  select_region.empty();
  select_region.append('<option selected="true" disabled>Choose Region</option>');
  select_region.prop('selectedIndex', 0);
  $.each(region_data, function (key, entry) {
    select_region.append('<option value="' + entry.regDesc + '" data-code="' + entry.regCode + '">' + entry.regDesc + '</option>');
  })


$(document).on('change', '.region', function(e){
  let regcode = $('option:selected',this).data("code");
  let type = $(this).attr('data-type');
  if(type == 'present')
  {
    present_province.prop('disabled', false);
    present_province.empty();
    present_province.append('<option selected="true" disabled>Choose Province</option>');
    present_province.prop('selectedIndex', 0);
  }
  else
  {
    provincial_province.prop('disabled', false);
    provincial_province.empty();
    provincial_province.append('<option selected="true" disabled>Choose Province</option>');
    provincial_province.prop('selectedIndex', 0);
  }
  populateProvince(regcode, type);
})

$(document).on('change', '.province', function(e){
  let provcode = $('option:selected',this).data("code");
  let type = $(this).attr('data-type');
  if(type == 'present')
  {
    present_citymun.prop('disabled', false);
    present_citymun.empty();
    present_citymun.append('<option selected="true" disabled>Choose City/Municipality</option>');
    present_citymun.prop('selectedIndex', 0);
  }
  else
  {
    provincial_citymun.prop('disabled', false);
    provincial_citymun.empty();
    provincial_citymun.append('<option selected="true" disabled>Choose City/Municipality</option>');
    provincial_citymun.prop('selectedIndex', 0);
  }
  populateCityMun(provcode, type);
})

$(document).on('change', '.citymun', function(e){
  let citycode = $('option:selected',this).data("code");
  let type = $(this).attr('data-type');
  if(type == 'present')
  {
    present_barangay.prop('disabled', false);
    present_barangay.empty();
    present_barangay.append('<option selected="true" disabled>Choose Barangay</option>');
    present_barangay.prop('selectedIndex', 0);
  }
  else
  {
    provincial_barangay.prop('disabled', false);
    provincial_barangay.empty();
    provincial_barangay.append('<option selected="true" disabled>Choose Barangay</option>');
    provincial_barangay.prop('selectedIndex', 0);
  }
  populateBrgy(citycode, type);
})

function populateProvince(regcode, type)
{
    for(x in province_data)
    {   
        if(province_data[x].regCode == regcode)
        {
          if(type == 'present')
          {
            present_province.append('<option value="' + province_data[x].provDesc + '" data-code="' + province_data[x].provCode + '">' + province_data[x].provDesc + '</option>');
          }
          else
          {
            provincial_province.append('<option value="' + province_data[x].provDesc + '" data-code="' + province_data[x].provCode + '">' + province_data[x].provDesc + '</option>');
          }
        }
    }
 
}

function populateCityMun(provcode, type)
{
    for(x in citymun_data)
    {   
        if(citymun_data[x].provCode == provcode)
        {
          if(type == 'present')
          {
            present_citymun.append('<option value="' + citymun_data[x].citymunDesc + '" data-code="' + citymun_data[x].citymunCode + '">' + citymun_data[x].citymunDesc + '</option>');
          }
          else
          {
            provincial_citymun.append('<option value="' + citymun_data[x].citymunDesc + '" data-code="' + citymun_data[x].citymunCode + '">' + citymun_data[x].citymunDesc + '</option>');
          }
        }
    }
}

function populateBrgy(citycode, type)
{
    for(x in brgy_data)
    {   
        if(brgy_data[x].citymunCode == citycode)
        {
          if(type == 'present')
          {
            present_barangay.append('<option value="' + brgy_data[x].brgyDesc + '" data-code="' + brgy_data[x].brgyCode + '">' + brgy_data[x].brgyDesc + '</option>');
          }
          else
          {
            provincial_barangay.append('<option value="' + brgy_data[x].brgyDesc + '" data-code="' + brgy_data[x].brgyCode + '">' + brgy_data[x].brgyDesc + '</option>');
          }
        }
    }
}

 let downlines = [];
 let table = document.getElementById("list-table");
 for (var i = 2; i < table.rows.length; i++) {
     var account_id = table.rows[i].cells[1].innerText.split("-");
     if(account_id[0] != "")
     {
       downlines[i] = account_id[0].toUpperCase();
     }
 }

$('#btn_search').click(function(e) {
   e.preventDefault();
   let val = $('#search_input').val()
   let new_url = base_url+"/member/network-tree/index/"+val;

   if(val != '')
   {   
       if(!downlines.includes(val.toUpperCase()))
       {
           $('.message').text('Account ID. not found!');
           $('#message_modal').modal('show');
           return false;
       }
       
       $.ajax({
               type : 'GET',
               url  : base_url+'/member/search/'+val,
               success : function(data) {
                   if(data.errors)
                   {
                       $('.message').text(data.errors);
                       $('#message_modal').modal('show');
                   }
                   else
                   {
                     window.location.replace(base_url+"/member/network-tree/index/"+data.account_id+'-'+data.user_id);
                   }
               }
       });
 }
 else 
 {
     $('.message').text('Please enter an id!');
     $('#message_modal').modal('show');
 }
});

$('.upgrade_button').on('click', function(e){
     e.preventDefault();
     // $('#span-user_id').text($(this).attr('data-id'));
     $('#user_id').val($(this).attr('data-id'));
     $('#activation_code').val();
     $('#upgrade_modal').modal('show');
 });
 
$('#upgrade_submit').on('click', function(e){
   e.preventDefault();
   // let user_id = $('#user_id').text();
   // let account_id = $('#account_id').val();
   // let activation_code = $('#activation_code').val();
   
   var form = $('#upgrade_form');
   var upgrade_url =  base_url+'/member/'+form.attr('action');
   var upgrade_data = form.serialize();

   if(account_id == '' || activation_code == '')
   {
       $('#error_message').text("Input fields are required!");
   }
   else
   {
       $.ajax({
       type : 'POST',
       url  : upgrade_url,
       data : upgrade_data,
       success : function(data) {
             if(data.errors)
             {
               $('#error_message').text(data.errors);
             }
             else {
                 $('#upgrade_modal').modal('hide');
                 $('.modal-title').text('Upgraded!');
                 $('.message').text('Upgrade successful!');
                 $('#message_modal').modal('show');
               setTimeout(function() {
                 $('#message_modal').modal('hide');
                 },3000);
                 // $( "#network-tree" ).load( window.location.href+" #network-tree" );
                 reload();
             }
         }
     });
   }
});

$('#upgrade_modal').on('hidden.bs.modal', function() {
   $('#upgrade_form')[0].reset();
   $('#error_message').text('');
});

// $('#btn_search_sponsor').on('click', function(e){
//     e.preventDefault();

//      
//      var sponsor_id = $('#sponsor_id').val();
//      var sponsor =  base_url+'/member/network-tree/sponsor/'+sponsor_id;
//      if(!sponsor_id)
//      {
//         $('#error_sponsor_id').text('Please Enter Sponsor ID.');
//         return false;
//      }
//      $.ajax({
//          type: 'GET',
//          url: sponsor,
//          success : function(data) {
//             if(data.errors)
//             {
//               $('#error_sponsor_id').text(data.errors);
//             }
//             else
//             {
//               $('#error_sponsor_id').text('');
//               $('#sponsor_name').val(data.sponsor_name);
//               $('#error_sponsor_name').text('');
//             }
//          }
//     });
//  });

 $(document).on('input','#sponsor_id', function(e){
    e.preventDefault();

     
     var sponsor_id = $('#sponsor_id').val();
     var sponsor =  base_url+'/member/network-tree/sponsor/'+sponsor_id;
     if(!sponsor_id)
     {
        $('#error_sponsor_id').text('Please Enter Sponsor ID.');
        return false;
     }

     $.ajax({
         type: 'GET',
         url: sponsor,
         success : function(data) {
            if(data.errors)
            {
              $('#error_sponsor_id').text(data.errors);
              $('#sponsor_name').val('');
              $('#error_sponsor_name').text('The sponsor name field is required.');
            }
            else
            {
              $('#error_sponsor_id').text('');
              $('#sponsor_name').val(data.sponsor_name);
              $('#error_sponsor_name').text('');
            }
         }
    });
 });

//Activation button
$('.activate_button').on('click', function(e){
    
    var upline =  base_url+'/member/network-tree/upline';
 
    e.preventDefault();
    $.ajax({
        type: 'GET',
        url: upline,
        data: {
            // '_token': $('input[name=_token]').val(),
            'upline_id': $(this).attr('data-upline'),
            'node': $(this).attr('data-node'),
        },
        success : function(data) {
            $('#upline_id').val(data.upline);
            $('#upline_name').val(data.upline_name);
            $('#node').val(data.node_replacement); 
            $('#activate_modal').modal('show');
        }
   });
});


// member next button
$(document).on('click', '#nxt_account', function(e){
    e.preventDefault();

    validateAccount(function(data){
        $('#error_activation_code').text('');
        $('#error_account_id').text('');
        if(data.invalid_code)
        {
            (data.invalid_code) ? $('#error_activation_code').text(data.invalid_code) : '';
            (data.invalid_code) ? $('#error_account_id').text(data.invalid_code) : '';
        }
    
        if (data.errors) {
            (data.errors.activation_code) ? $('#error_activation_code').text(data.errors.activation_code) : '';
            (data.errors.sponsor_id) ? $('#error_sponsor_id').text(data.errors.sponsor_id) : $('#error_sponsor_id').text('');
            (data.errors.sponsor_name) ? $('#error_sponsor_name').text(data.errors.sponsor_name) : $('#error_sponsor_name').text('');
            (data.errors.account_id) ? $('#error_account_id').text(data.errors.account_id) : '';        
        }

        if(data.success)
        {
            $('#myTabs a[href="#member_details"]').tab('show');
        }
     });
})

// validate account tab
function validateAccount(callback)
{  
   var data = {};
   data['account_id'] = $('#account-id').val();
   data['activation_code'] = $('#activation-code').val();
   data['sponsor_id'] = $('#sponsor_id').val();
   data['sponsor_name'] = $('#sponsor_name').val();
   data['validate'] = 'account';
   
   var validate =  base_url+'/member/network-tree/validate';
   // var data = $('#activate_form').serialize();
   $.ajax({
        type: 'GET',
        url: validate,
        data: data,
        success : callback 
   });

}


$(document).on('click', '#back_member', function(e){
    e.preventDefault();
     // Select tab by name
     $('#myTabs a[href="#account_details"]').tab('show');
})

// member next button
$(document).on('click', '#nxt_member', function(e){
    e.preventDefault();

    validateMember(function(data){
        
        $('#error_coop_id').text('');
        $('#error_first_name').text('');
        $('#error_middle_name').text('');
        $('#error_last_name').text('');
        $('#error_username').text('');
        $('#error_email').text('');
        $('#error_password').text('');
        $('#error_confirm_password').text('');
        
        if (data.errors) {
            (data.errors.coop_id) ? $('#error_coop_id').text(data.errors.coop_id) : $('#error_coop_id').text('');
            (data.errors.first_name) ? $('#error_first_name').text(data.errors.first_name) : $('#error_first_name').text('');
            (data.errors.first_name) ? $('#error_middle_name').text(data.errors.middle_name) : $('#error_middle_name').text('');
            (data.errors.last_name) ? $('#error_last_name').text(data.errors.last_name) : $('#error_last_name').text('');
            (data.errors.username) ? $('#error_username').text(data.errors.username) : $('#error_username').text('');
            (data.errors.email) ? $('#error_email').text(data.errors.email) : $('#error_email').text('');
            (data.errors.password) ? $('#error_password').text(data.errors.password) : $('#error_password').text('');
            (data.errors.password_confirmation) ? $('#error_confirm_password').text(data.errors.password_confirmation) : $('#error_confirm_password').text('');
        }

        if(data.success)
        {
            $('#myTabs a[href="#other_details"]').tab('show');
        }
     });
     
})

$(document).on('click', '#back_other', function(e){
    e.preventDefault();
     // Select tab by name
     $('#myTabs a[href="#member_details"]').tab('show');
})

// validate member tab
 function validateMember(callback)
 {  
    var data = {};
    data['coop_id'] = $('#coop_id').val();
    data['first_name'] = $('#first_name').val();
    data['middle_name'] = $('#middle_name').val();
    data['last_name'] = $('#last_name').val();
    data['username'] = $('#username').val();
    data['email'] = $('#email').val();
    data['password'] = $('#password').val();
    data['password_confirmation'] = $('#password_confirmation').val();
    data['validate'] = 'member';
    
    var validate =  base_url+'/member/network-tree/validate';
    // var data = $('#activate_form').serialize();
    $.ajax({
         type: 'GET',
         url: validate,
         data: data,
         success : callback 
    });

 }

 $(document).on('click', '#activate_confirm', function(e){
     e.preventDefault();
    
     validateOther(function(data){
       
        $('#error_true_money').text('');
        $('#error_cel_number').text('');
        $('#error_present_region').text('');
        $('#error_present_province').text('');
        $('#error_present_barangay').text('');
        $('#error_present_city_mun').text('');
 
        if (data.errors) {
            (data.errors.true_money) ? $('#error_true_money').text(data.errors.true_money) : $('#error_true_money').text('');
            (data.errors.cel_number) ? $('#error_cel_number').text(data.errors.cel_number) : $('#error_cel_number').text('');
            (data.errors.present_region) ? $('#error_present_region').text(data.errors.present_region) : $('#error_present_region').text('');
            (data.errors.present_province) ? $('#error_present_province').text(data.errors.present_province) : $('#error_present_province').text('');
            (data.errors.present_barangay) ? $('#error_present_barangay').text(data.errors.present_barangay) : $('#error_present_barangay').text('');
            (data.errors.present_city_mun) ? $('#error_present_city_mun').text(data.errors.present_city_mun) : $('#error_present_city_mun').text('');
        }

        if(data.success)
        {   
            $('.new_details').removeClass('hidden');
            $('.old_details').addClass('hidden');
            verifyData();
        }
     });
 })

 // validate other tab
 function validateOther(callback)
 {  
    
    var data = {};
    data['true_money'] = $('#trueMoney').val();
    data['cel_number'] = $('#cel_number').val();
    data['present_barangay'] = $('#present_barangay').val();
    data['present_city_mun'] = $('#present_city_mun').val();
    data['present_region'] = $('#present_region').val();
    data['present_province'] = $('#present_province').val();
    data['validate'] = 'other';
    
    
    var validate =  base_url+'/member/network-tree/validate';
    // var data = $('#activate_form').serialize();
    $.ajax({
         type: 'GET',
         url: validate,
         data: data,
         success : callback
    });

 }

$(document).on('click', '#edit_info', function(e){
    e.preventDefault();
    $('#verify_modal').modal('hide');
    $('#activate_modal').modal('show');
})

$(document).on('click', '#verify_close', function(e){
    e.preventDefault();
  $('#verify_modal').modal('hide');
  $('#activate_modal').modal('show');
});

$(document).on('click', '#activation_close', function(e){
    e.preventDefault();
   $('#warning_modal h4').text('Warning!');
   $('.message').text('Are you sure you want to close this form?');
   $('#warning_modal').modal('show');
});

$(document).on('click', '#btn_yes', function(e){
    e.preventDefault();
    $('#warning_modal').modal('hide');
    setTimeout(function() {
        $('#activate_form')[0].reset();
        $('.help-block').text('');
        $('#activate_modal').modal('hide');
    },1000);
});

// function stopInterval(interv)
// {
//     $(document).on('hidden.bs.modal','#activate_modal', function () {
        
        
//     });
// }

function verifyData()
{     
     let account_type = $('#own_Account');
     let uplineId = $('#upline_id').val();
     let uplineName = $('#upline_name').val();
     let sponsorId = $('#sponsor_id').val();
     let sponsorName = $('#sponsor_name').val();
     let account_id = $('#account-id').val();
     let activation_code = $('#activation-code').val();
     let node = $('#node').val();
     let coop_id = $('#coop_id').val();
     let fullName = $('#first_name').val()+' '+$('#middle_name').val() +' '+$('#last_name').val()+' '+$('#suffix').val();
     let username = $('#username').val();
     let email = $('#email').val();
     let address = $('#present_barangay').val()+' '+$('#present_city_mun').val();
     let cel_no = $('#cel_number').val();
     let truemoney = $('#trueMoney').val();

     // account details
     $('#verify_upline_id').text(uplineId);
     $('#verify_upline_name').text(uplineName);
     $('#verify_sponsor_id').text(sponsorId);
     $('#verify_sponsor_name').text(sponsorName);
     $('#verify_account_id').text(account_id);
     $('#verify_activation_code').text(activation_code);
     $('#verify_node_placement').text(node);
     // member details
     $('#verify_coop_id').text(coop_id);
     $('#verify_full_name').text(fullName);
    $('#verify_email').text(email);
    $('#verify_username').text(username);
    $('#verify_address').text(address);
    $('#verify_cel_no').text(cel_no);
    $('#verify_truemoney').text(truemoney);
   
     $('#verify_modal').modal('show');
     $('#activate_modal').modal('hide');
}

$(document).on('change', '#own_Account', function(e){
    e.preventDefault();
    
    let val = $(this).val();

    if(val == 'own account')
    {   
        // $('#tab_member').addClass('hidden');
        // $('#tab_other').addClass('hidden');
        // $('#nxt_account').addClass('hidden');
        // $('#submit_activation').removeClass('hidden');
        $('#tab_member').removeClass('hidden');
        $('#tab_other').removeClass('hidden');
        $('#nxt_account').removeClass('hidden');
        $('#submit_activation').addClass('hidden');
        $('#error_account_option').text('');
    }

    if(val == 'own account')
    {   
        checkAccountExceed(function(data){
            $('#error_account_option').text('');
            if(data.error)
            {
                $('#error_account_option').text(data.error);
                $('#new').attr('selected', true);
            }

            if(data.success)
            {
                $('#tab_member').addClass('hidden');
                $('#tab_other').addClass('hidden');
                $('#nxt_account').addClass('hidden');
                $('#submit_activation').removeClass('hidden');
            }
        });
        
    }
    
})

function checkAccountExceed(callback)
{
    
    var check =  base_url+'/member/network-tree/check-account';
    // var data = $('#activate_form').serialize();
    $.ajax({
         type: 'GET',
         url: check,
         success : callback
    });
}


$(document).on('click', '#submit_activation', function(e){
    e.preventDefault();

    validateAccount(function(data){
        $('#error_activation_code').text('');
        $('#error_account_id').text('');
        if(data.invalid_code)
        {
            (data.invalid_code) ? $('#error_activation_code').text(data.invalid_code) : '';
            (data.invalid_code) ? $('#error_account_id').text(data.invalid_code) : '';
        }
    
        if (data.errors) {
            (data.errors.activation_code) ? $('#error_activation_code').text(data.errors.activation_code) : '';
            (data.errors.sponsor_id) ? $('#error_sponsor_id').text(data.errors.sponsor_id) : $('#error_sponsor_id').text('');
            (data.errors.sponsor_name) ? $('#error_sponsor_name').text(data.errors.sponsor_name) : $('#error_sponsor_name').text('');
            (data.errors.account_id) ? $('#error_account_id').text(data.errors.account_id) : '';        
        }
    
        if(data.success)
        {
            
            $('.new_details').addClass('hidden');
            $('.old_details').removeClass('hidden');
            
            verifyData();
        }

     });
})

$(document).on('click', '#activation_submit', function(e){
    e.preventDefault();
    var promise;
    $(document).off('click', '#activation_submit');
    let account = $('#own_Account').val();

    if(account == 'own account')
    {   
        let data = {};
        data['own_Account'] = account;
        data['upline_id'] = $('#upline_id').val();
        data['upline_name'] = $('#upline_name').val();
        data['sponsor_id'] = $('#sponsor_id').val();
        data['sponsor_name']  = $('#sponsor_name').val();
        data['account_id'] = $('#account-id').val();
        data['activation_code'] = $('#activation-code').val();
        data['node_placement'] = $('#node').val();
        data['for_username'] = $('#for_username').val();

        promise = activateAccount(data);
    }

    if(account == 'new account')
    {
        let data = $('#activate_form').serialize();
        promise = activateAccount(data);
    }

    successActivation(promise);
    
})

function successActivation(promise_data)
{
    if(promise_data === undefined)
    {
        
        $('#verify_modal').modal('hide');
        $('.modal-title').text('Activated!');
        $('.message').text('Activated successful!');
        $('#message_modal').modal('show');
        setTimeout(function() {
        $('#message_modal').modal('hide');
        },3000);
        // $( "#network-tree" ).load( window.location.href+" #network-tree" );
        reload();
       
    }
    
}

function activateAccount(data_field)
{
    
    var activate =  base_url+'/member/network-tree/activate';
    $.ajax({
         type: 'POST',
         url: activate,
         data: data_field,
         success : function(data){
             return data;
            
         }
    });  
}

function showActivationModal()
{
    $(document).on('hidden.bs.modal','#verify_modal', function () {
        $('#activate_modal').modal('show');
    });

}

function reload()
{
   $(document).on('hidden.bs.modal','#message_modal', function () {
       location.reload();
   });
}

$('body').on('hidden.bs.modal', function () {
    if($('.modal.in').length > 0)
    {
        $('body').addClass('modal-open');
    }
});

