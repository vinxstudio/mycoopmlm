@extends('layouts.members')
@section('content')

<?php
use App\Helpers\Binary;

$binary = new Binary();

?>
<style>
.popupContainer {
    position: absolute;
    width: 330px;
    height: auto;
    left: 45%;
    top: 60px;
    background: #FFF;
}

#modal_trigger {
    margin: 40px auto;
    width: 200px;
    display: block;
    border: 1px solid #DDD;
    border-radius: 4px;
}
/*
.btn {
    padding: 10px 20px;
    background: #F4F4F2;
}

.btn_red {
    background: #ED6347;
    color: #FFF;
}

.btn:hover {
    background: #E4E4E2;
}

.btn_red:hover {
    background: #C12B05;
}

a.btn {
    color: #666;
    text-align: center;
    text-decoration: none;
}

a.btn_red {
    color: #FFF;
    color: #FFF;
}*/

.one_half {
    width: 50%;
    display: block;
    float: left;
}

.one_half.last {
    width: 45%;
    margin-left: 5%;
}
/* Popup Styles*/

.popupHeader {
    font-size: 16px;
    text-transform: uppercase;
}

.popupHeader {
    background: #F4F4F2;
    position: relative;
    padding: 10px 20px;
    border-bottom: 1px solid #DDD;
    font-weight: bold;
}

.popupHeader .modal_close {
    position: absolute;
    right: 0;
    top: 0;
    padding: 10px 15px;
    background: #E4E4E2;
    cursor: pointer;
    color: #aaa;
    font-size: 16px;
}

.popupBody {
    padding: 20px;
}
/* Social Login Form */

.social_login {}

.social_login .social_box {
    display: block;
    clear: both;
    padding: 10px;
    margin-bottom: 10px;
    background: #F4F4F2;
    overflow: hidden;
}

.social_login .icon {
    display: block;
    width: 10px;
    padding: 5px 10px;
    margin-right: 10px;
    float: left;
    color: #FFF;
    font-size: 16px;
    text-align: center;
}

.social_login .fb .icon {
    background: #3B5998;
}

.social_login .google .icon {
    background: #DD4B39;
}

.social_login .icon_title {
    display: block;
    padding: 5px 0;
    float: left;
    font-weight: bold;
    font-size: 16px;
    color: #777;
}

.social_login .social_box:hover {
    background: #E4E4E2;
}

.centeredText {
    text-align: center;
    margin: 20px 0;
    clear: both;
    overflow: hidden;
    text-transform: uppercase;
}

.action_btns {
    clear: both;
    overflow: hidden;
}

.action_btns a {
    display: block;
}
/* User Login Form */

.user_login {
    display: none;
}

.user_login label {
    display: block;
    margin-bottom: 5px;
}

.user_login input[type="text"],
.user_login input[type="email"],
.user_login input[type="password"] {
    display: block;
    width: 90%;
    padding: 10px;
    border: 1px solid #DDD;
    color: #666;
}

.user_login input[type="checkbox"] {
    float: left;
    margin-right: 5px;
}

.user_login input[type="checkbox"]+label {
    float: left;
}

.user_login .checkbox {
    margin-bottom: 10px;
    clear: both;
    overflow: hidden;
}

.forgot_password {
    display: block;
    margin: 20px 0 10px;
    clear: both;
    overflow: hidden;
    text-decoration: none;
    color: #ED6347;
}
/* User Register Form */

.user_register {
    display: none;
}

.user_register label {
    display: block;
    margin-bottom: 5px;
}

.user_register input[type="text"],
.user_register input[type="email"],
.user_register input[type="password"] {
    display: block;
    width: 90%;
    padding: 10px;
    border: 1px solid #DDD;
    color: #666;
}

.user_register input[type="checkbox"] {
    float: left;
    margin-right: 5px;
}

.user_register input[type="checkbox"]+label {
    float: left;
}

.user_register .checkbox {
    margin-bottom: 10px;
    clear: both;
    overflow: hidden;
}

.network-tree > img{
  top:190px;
    width: 1200px;
    position: absolute;
    z-index: -1;
}
.container1{
    height: 700px;
    margin: 0 auto;
    width: 100%;
}
.node{
  width: 140px;
  text-align: center; 
  padding: 3px;
}

.node > img{
  border-radius: 50px;
}

.node-empty{
  margin-bottom:55px!important;
}

.node-last{
  width: 65px;
  text-align: center; 
  padding: 3px;
}

.node-last > img{
  border-radius: 50px;
}

.btn-sm{
  background: #F4F4F2;
    color: #666;
    padding: 5px;
}
.modal-backdrop {
  position: unset !important;
}

.container1 {

  width: 100%;
  height:100%;
  position: relative;

}
.tree ul {
  position: relative;
  padding: 1em 0em;
  white-space: nowrap;
  margin: 0 auto;
  text-align: center;
}
.tree ul::after {
  content: '';
  display: table;
  clear: both;
}

.tree li {
  display: inline-block;
  vertical-align: top;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding:  1em .05em 0 .10em;
}
.tree li::before, .tree li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 2px solid #333;
  width: 55%;
  height: 1em;
}
.tree li::after {
  right: auto;
  left: 50%;
  border-left: 2px solid #333;
}
.tree li:only-child::after, .tree li:only-child::before {
  display: none;
}
.tree li:only-child {
  padding-top: 0;
}
.tree li:first-child::before, .tree li:last-child::after {
  border: 0 none;
}
.tree li:last-child::before {
  border-right: 2px solid #333;
  border-radius: 0 5px 0 0;
}
.tree li:first-child::after {
  border-radius: 5px 0 0 0;
}

.tree ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 2px solid #333;
  width: 0;
  height: 1em;
}

.tree li a {
  text-decoration: none;
}
.first-second .owner-info {
  height: 40px;
  margin-bottom: 35px;
}
.third-fourth .owner-info {
  height: 40px;
  margin-bottom: 25px;
}

.fifth .owner-info {
  height: 40px;
  margin-bottom: 45px;
}

.first-second{
  border: 1px solid #ccc;
  padding: 3em .5em;
  display: inline-block;
  position: relative;
  width: 150px;
  height: 160px;
  top: 1px;
  white-space: initial;
  background-color: #ddd;
  line-height: normal;

}
.first-second .numbering {
  width: 10px;
  height: 30px;
  font-size: 15px;
  font-weight: bold;
  margin-top:-30px;
}
.first-second img {
  border-radius: 50%;
  width: 40px;
  height: 40px;
  object-fit: contain;
  margin-top: -35px;
  text-align: center;
}

.first-second .button{
  background-color: blue;
  color: #fff;
  padding: 5px;
  border-radius: 10px 10px 10px 10px;
}

.first-second .owner-name {
  font-size: 14px;
  padding: 5px 0;
  font-weight: bold;
  color: blue;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: initial;
  overflow: hidden;
}

.first-second .owner-id {
  font-size: 10px;
  color: black;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: nowrap;
  overflow: hidden;
}

.third-fourth {
  border: 1px solid #ccc;
  padding: 3em 0.5em;
  display: inline-block;
  position: relative;
  width: 130px;
  height: 150px;
  top: 1px;
  white-space: initial;
  background-color: #ddd;
  line-height: normal;
}

.third-fourth .numbering {
  width: 11px;
  height: 30px;
  font-size: 12px;
  font-weight: bold;
  margin-top:-30px;
}

.third-fourth img {
  border-radius: 50%;
  width: 35px;
  height: 35px;
  object-fit: contain;
  margin-top: -35px;
}

.third-fourth .owner-name {
  font-size: 12px;
  padding: 5px 0;
  font-weight: bold;
  color: blue;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: initial;
  overflow: hidden;
}

.third-fourth .owner-id {
  font-size: 10px;
  color: black;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: nowrap;
  overflow: hidden;
}
.third-fourth .button{
  background-color: blue;
  color: #fff;
  padding: 5px;
  font-size: 10px;
  border-radius: 10px 10px 10px 10px;
}

.fifth {
 border: 1px solid #ccc;
 padding: 3em 0.5em;
 display: inline-block;
 position: relative;
 width: 70px;
 height: 165px;
 top: 1px;
 background-color: #ddd;
 line-height: normal;
}
.fifth .numbering {
  width: 10px;
  height: 30px;
  font-size: 10px;
  font-weight: bold;
  margin-top:-30px;
}

.fifth img {
  border-radius: 50%;
  width: 30px;
  height: 30px;
  object-fit: contain;
  margin-top: -35px;
}

.fifth .owner-name {
  font-size: 10px;
  padding: 5px 0;
  font-weight: bold;
  color: blue;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: initial;
  overflow: hidden;
}

.fifth .owner-id {
  font-size: 7px;
  color: black;
  text-overflow: ellipsis;
  /* Required for text-overflow to do anything */
  white-space: nowrap;
  overflow: hidden;
}

.fifth .button{
  background-color: blue;
  color: #fff;
  padding: 5px;
  font-size: 8px;
  border-radius: 10px 10px 10px 10px;
}

#table {
  margin-top: -30px;
}
div.searchbox {
    margin: 0 auto;
    width: 60%;
    height: 110px;
    background: rgb(66, 140, 179);  
    text-align: center;
    padding: 10px 0;
    margin-bottom: 10px;
}

div#current_user {
  color: #fff;
  border-top:2px solid #00B1E1;
}

#user_details {
  padding-top: 10px;
}

#user_details .user_name{
  font-size: 18px;
  padding-left: 5px;
}

.tree li a:hover + ul li::after,
.tree li a:hover + ul li::before,
.tree li a:hover + ul::before,
.tree li a:hover + ul ul::before {
  border-color: #54B3E3;
}

</style>
<div class="container1" id="network_tree">
  <div class="searchbox">
    <div class="col-md-12 form-group">
      <form>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-search"></i></span>
          <input id="search_input" name="account_id" type="text" class="form-control" placeholder="Search ID...">
          <span class="input-group-btn">
            <button class="btn btn-primary" id="btn_search">Search</button>
          </span>
        </div>
      </form>  
    </div>
    <div class="col-md-12" id="current_user" >
      <div id="user_details">
        <i class="fa fa-users fa-w-20 fa-2x"></i>
      <span class="user_name">{{$currentUser->details->fullName}} ( {{$currentUser->account->code->account_id.'-'.$currentUser->id}} )</span>
      </div>
    </div>
  </div>
  <div class="" style="height: 50px;">
    @if (count($viewed) > 0)
        <ul class="breadcrumb">
            <li>
                <a href="{{ url('member/network-tree') }}">You : {{ $theUser->account->code->account_id }}</a>
            </li>
            @foreach ($viewed as $userID)
                <li>
                    <a href="{{ url(sprintf('member/network-tree/index/%s-%s', strtoupper($listedUser[$userID]->account->code->account_id), $userID)) }}">{{ strtoupper($listedUser[$userID]->account->code->account_id) }}</a>
                </li>
            @endforeach
        </ul>
    @endif
  </div>
    {{ Html::style('public/plugins/jquery-orgchart/jquery.orgchart.css') }}
    <?php $today = getdate(); ?>
    <script>
        var d = new Date(<?php echo $today['year'].",".$today['mon'].",".$today['mday'].",".$today['hours'].",".$today['minutes'].",".$today['seconds']; ?>);
        setInterval(function() {
            d.setSeconds(d.getSeconds() + 1);
            $('#timer').text((d.getHours() +':' + d.getMinutes() + ':' + d.getSeconds() ));
        }, 1000);
    </script>

    <label id="date">Server Date Time: <?php echo $today['year']."-".$today['mon']."-".$today['mday']; ?></label>
    <label id="timer"></label>
  <div class="tree">
   <?php
    $lvl2 = $binary->getAccountTree($account_id);
    
    $lvl3_left = (!empty($lvl2['left']))? $binary->getAccountTree($lvl2['left']['account_id']) : null;
    $lvl3_right = (!empty($lvl2['right']))? $binary->getAccountTree($lvl2['right']['account_id']) : null;

    $lvl4_left_A = (!empty($lvl3_left['left']))? $binary->getAccountTree($lvl3_left['left']['account_id']) : null;
    $lvl4_right_A = (!empty($lvl3_left['right']))? $binary->getAccountTree($lvl3_left['right']['account_id']) : null;

    $lvl4_left_B = (!empty($lvl3_right['left']))? $binary->getAccountTree($lvl3_right['left']['account_id']): null;
    $lvl4_right_B = (!empty($lvl3_right['right']))? $binary->getAccountTree($lvl3_right['right']['account_id']): null;
    $lvl5_left_A = (!empty($lvl4_left_A['left']))? $binary->getAccountTree($lvl4_left_A['left']['account_id']) : null;
    $lvl5_right_A = (!empty($lvl4_left_A['right']))? $binary->getAccountTree($lvl4_left_A['right']['account_id']) : null;

    $lvl5_left_B = (!empty($lvl4_right_A['left']))? $binary->getAccountTree($lvl4_right_A['left']['account_id']): null;
    $lvl5_right_B = (!empty($lvl4_right_A['right']))? $binary->getAccountTree($lvl4_right_A['right']['account_id']): null;

    $lvl5_left_C = (!empty($lvl4_left_B['left']))? $binary->getAccountTree($lvl4_left_B['left']['account_id']) : null;
    $lvl5_right_C = (!empty($lvl4_left_B['right']))? $binary->getAccountTree($lvl4_left_B['right']['account_id']) : null;

    $lvl5_left_D = (!empty($lvl4_right_B['left']))? $binary->getAccountTree($lvl4_right_B['left']['account_id']): null;
    $lvl5_right_D = (!empty($lvl4_right_B['right']))? $binary->getAccountTree($lvl4_right_B['right']['account_id']): null;
    ?>
    @include('Member.NetworkTree.views.tree')
  </div>
  <div id="table">
     @include('Member.NetworkTree.views.tree-table')
  </div>
</div>
@include('Member.NetworkTree.views.modals')
@stop

@section('custom_includes')
    {{ Html::script('public/plugins/jquery-orgchart/jquery.orgchart.min.js') }}
<script>
  function popUp(URL) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=800,left = 283,top = -16');");
  }
  function popUp2(URL) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400,left = 283,top = -16');");

  }
  $(document).on('click', '#modal_trigger', function(e) {
    e.preventDefault();
   
   $(".user_register").show();
        $(".header_title").text('Register');
        return false;
  });  
    
  $(document).ready(function(){
     $('.ViewImage').on('click',function(){
         // some code is executed which brings up the popup 
         // now we know that the image is added into html we can now run the script
        $("#modal_trigger").click(function (){
           //your logic here
         $(".user_register").show();
            $(".header_title").text('Register');
            return false;
         
         });
     });
  });
  $("#chart").orgChart({container: $("#main")});
      // Plugin options and our code
  // $("#modal_trigger").leanModal({
  //     top: 100,
  //     overlay: 0.6,
  //     closeButton: ".modal_close"
  // });

  $(function() {
      
          $(".user_register").show();
          $(".header_title").text('Register');
          return false;
  });
</script>
{{ Html::script('public/custom/js/network_tree.js') }}
<!--<script src='https://andwecode.com/wp-content/uploads/2015/10/jquery.leanModal.min_.js'></script>-->
<!--    <script type="text/javascript">
        $("#chart").orgChart({container: $("#main")});
            // Plugin options and our code
        // $("#modal_trigger").leanModal({
        //     top: 100,
        //     overlay: 0.6,
        //     closeButton: ".modal_close"
        // });

        $(function() {
            
                $(".user_register").show();
                $(".header_title").text('Register');
                return false;
        });
    </script> -->
<!--    <script>
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
        let base_url = window.location.origin;
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

     $('.activate_button').on('click', function(e){
          e.preventDefault();
         
          $('#activate_modal').modal('show');
      });

      $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
      
     $('#upgrade_submit').on('click', function(e){
        e.preventDefault();
        // let user_id = $('#user_id').text();
        // let account_id = $('#account_id').val();
        // let activation_code = $('#activation_code').val();
        var base_url = window.location.origin;
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
                    setInterval(function() {
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
     function reload()
     {
        $(document).on('hidden.bs.modal','#message_modal', function () {
            location.reload();
        });
     }
    </script>
  -->
@stop
