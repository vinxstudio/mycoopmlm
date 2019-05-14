<ul>
  <li>
    <div class="first-second" style="background-color:{{ $color }}">
        <div class="numbering">1</div>
        <img src="{{ url($currentUser->details->thePhoto) }}">
        <div class="owner-info">
            <div class="owner-id">ID: {{ $currentUser->account->code->account_id }}</div>
            <div class="owner-name">{{$currentUser->details->fullName}}</div>
        </div>
        @if($currentUser->account->code->type != 'Package C')
           <a href="#" class="button upgrade_button" data-id="{{ $currentUser->id }}">UPGRADE</a>     
        @endif
    </div>
    <?php
      $lvl2 = $binary->getAccountTree($account_id);
    ?>
    <ul>
      <li>
        <div class="first-second" style="background-color:{{ !empty($lvl2['left']['color']) ? $lvl2['left']['color'] :'#ddd';  }}">
          <div class="numbering">2</div>
          @if(!empty($lvl2['left']))
          <img src="{{ url($lvl2['left']['currentUser']->user->details->thePhoto) }}">
          <div class="owner-info">
            <a href="{{url('member/network-tree/index/'.strtoupper($lvl2['left']['currentUser']->code->account_id).'-'.$lvl2['left']['currentUser']->user->id)}}">
              <div class="owner-id">ID: {{ $lvl2['left']['currentUser']->code->account_id  }}</div>
              <div class="owner-name">{{ $lvl2['left']['currentUser']->user->details->fullName  }}</div>
            </a>
          </div>
          @if($lvl2['left']['currentUser']->code->type != 'Package C')
               <a href="#" class="button upgrade_button" data-id="{{ $lvl2['left']['currentUser']->user->id }}">UPGRADE</a>     
          @endif
          @else
             @if(!empty($account_id))
                    <?php
                        $uplineId = $currentUser->account->code->account_id;
                        $sponsorId = $theUser->account->code->account_id;
                        $theusername = $theUser->username;
                        $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                    ?>
                    <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                    <div class="owner-info">
                        <div class="owner-id">--------------------------</div>
                        <div class="owner-name">------------------------</div>
                    </div>
                    <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
             @else
                <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                <div class="owner-info">
                    <div class="owner-id">--------------------------</div>
                    <div class="owner-name">------------------------</div>
                </div>
             @endif
         @endif
        </div>
        <ul>
          <li>
          <div class="third-fourth" style="background-color:{{ !empty($lvl3_left['left']['color']) ? $lvl3_left['left']['color'] :'#ddd';  }}">
            <div class="numbering">4</div>
            @if(!empty($lvl3_left['left']))
              <img src="{{ url($lvl3_left['left']['currentUser']->user->details->thePhoto) }}">
              <div class="owner-info">
                <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_left['left']['currentUser']->code->account_id).'-'.$lvl3_left['left']['currentUser']->user->id)}}">
                  <div class="owner-id">ID: {{ $lvl3_left['left']['currentUser']->code->account_id  }}</div>
                  <div class="owner-name">{{ $lvl3_left['left']['currentUser']->user->details->fullName  }}</div>
                </a>
              </div>
              @if($lvl3_left['left']['currentUser']->code->type != 'Package C')
                   <a href="#" class="button upgrade_button" data-id="{{ $lvl3_left['left']['currentUser']->user->id}}">UPGRADE</a>     
            @endif
            @else
               @if(!empty($lvl2['left']))
                      <?php
                          $uplineId = $lvl2['left']['currentUser']->code->account_id;
                          $sponsorId = $theUser->account->code->account_id;
                          $theusername = $theUser->username;
                          $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                      ?>
                       <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                      <div class="owner-info">
                          <div class="owner-id">----------------------</div>
                          <div class="owner-name">------------------------</div>
                      </div>
                      <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
               @else
                  <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                  <div class="owner-info">
                      <div class="owner-id">----------------------</div>
                      <div class="owner-name">------------------------</div>
                  </div>
               @endif
           @endif
          </div>
          <ul>
            <li>
              <div class="third-fourth" style="background-color:{{ !empty($lvl4_left_A['left']['color']) ? $lvl4_left_A['left']['color'] :'#ddd';  }}">
                <div class="numbering">8</div>
                @if(!empty($lvl4_left_A['left']))
                  <img src="{{ url($lvl4_left_A['left']['currentUser']->user->details->thePhoto) }}">
                  <div class="owner-info">
                    <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_A['left']['currentUser']->code->account_id).'-'.$lvl4_left_A['left']['currentUser']->user->id)}}">
                      <div class="owner-id">ID: {{ $lvl4_left_A['left']['currentUser']->code->account_id  }}</div>
                      <div class="owner-name">{{ $lvl4_left_A['left']['currentUser']->user->details->fullName  }}</div>
                    </a>
                 </div>
                  @if($lvl4_left_A['left']['currentUser']->code->type != 'Package C')
                       <a href="#" class="button upgrade_button" data-id="{{ $lvl4_left_A['left']['currentUser']->user->id}}">UPGRADE</a>     
                @endif
                @else
                   @if(!empty($lvl3_left['left']))
                          <?php
                              $uplineId = $lvl3_left['left']['currentUser']->code->account_id;
                              $sponsorId = $theUser->account->code->account_id;
                              $theusername = $theUser->username;
                              $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                          ?>
                           <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------------------</div>
                              <div class="owner-name">------------------------</div>
                          </div>
                          <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                   @else
                      <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                      <div class="owner-info">
                          <div class="owner-id">----------------------</div>
                          <div class="owner-name">------------------------</div>
                      </div>
                   @endif
               @endif
              </div>
              <ul>
                <li>
                  <div class="fifth" style="background-color:{{ !empty($lvl5_left_A['left']['color']) ? $lvl5_left_A['left']['color'] :'#ddd';  }}">
                   <div class="numbering">16</div>
                    @if(!empty($lvl5_left_A['left']))
                      <img src="{{ url($lvl5_left_A['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_A['left']['currentUser']->code->account_id).'-'.$lvl5_left_A['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_A['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_A['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_A['left']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_A['left']['currentUser']->user->id}}">UPGRADE</a>     
                    @endif
                    @else
                       @if(!empty($lvl4_left_A['left']))
                              <?php
                                  $uplineId = $lvl4_left_A['left']['currentUser']->code->account_id;
                                  $sponsorId = $theUser->account->code->account_id;
                                  $theusername = $theUser->username;
                                  $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                              ?>
                               <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                              <div class="owner-info">
                                  <div class="owner-id">----------</div>
                                  <div class="owner-name">------------</div>
                              </div>
                              <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                       @else
                          <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------</div>
                              <div class="owner-name">------------</div>
                          </div>
                       @endif
                   @endif
                  </div>
                </li>
                <li>
                  <div class="fifth" style="background-color:{{ !empty($lvl5_left_A['right']['color']) ? $lvl5_left_A['right']['color'] :'#ddd';  }}">
                    <div class="numbering">17</div>
                    @if(!empty($lvl5_left_A['right']))
                    <img src="{{ url($lvl5_left_A['right']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_A['right']['currentUser']->code->account_id).'-'.$lvl5_left_A['right']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl5_left_A['right']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl5_left_A['right']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl5_left_A['right']['currentUser']->code->type != 'Package C')
                      <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_A['right']['currentUser']->user->id}}">UPGRADE</a>     
                    @endif
                    @else
                       @if(!empty($lvl4_left_A['left']))
                              <?php
                                  $uplineId = $lvl4_left_A['left']['currentUser']->code->account_id;
                                  $sponsorId = $theUser->account->code->account_id;
                                  $theusername = $theUser->username;
                                  $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                              ?>
                               <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                              <div class="owner-info">
                                  <div class="owner-id">----------</div>
                                  <div class="owner-name">------------</div>
                              </div>
                              <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                       @else
                          <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------</div>
                              <div class="owner-name">------------</div>
                          </div>
                       @endif
                     @endif
                  </div>
                </li>
              </ul>
            </li>
            <li>
              <div class="third-fourth" style="background-color:{{ !empty($lvl4_left_A['right']['color']) ? $lvl4_left_A['right']['color'] :'#ddd';  }}">
                <div class="numbering">9</div>
                @if(!empty($lvl4_left_A['right']))
                  <img src="{{ url($lvl4_left_A['right']['currentUser']->user->details->thePhoto) }}">
                  <div class="owner-info">
                    <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_A['right']['currentUser']->code->account_id).'-'.$lvl4_left_A['right']['currentUser']->user->id)}}">
                      <div class="owner-id">ID: {{ $lvl4_left_A['right']['currentUser']->code->account_id  }}</div>
                      <div class="owner-name">{{ $lvl4_left_A['right']['currentUser']->user->details->fullName  }}</div>
                    </a>
                 </div>
                  @if($lvl4_left_A['right']['currentUser']->code->type != 'Package C')
                       <a href="#" class="button upgrade_button" data-id="{{ $lvl4_left_A['right']['currentUser']->user->id}}">UPGRADE</a>   
                @endif
                @else
                   @if(!empty($lvl3_left['left']))
                          <?php
                              $uplineId = $lvl3_left['left']['currentUser']->code->account_id;
                              $sponsorId = $theUser->account->code->account_id;
                              $theusername = $theUser->username;
                              $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                          ?>
                          <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------------------</div>
                              <div class="owner-name">------------------------</div>
                          </div>
                          <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                   @else
                      <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                      <div class="owner-info">
                          <div class="owner-id">----------------------</div>
                          <div class="owner-name">------------------------</div>
                      </div>
                   @endif
               @endif
              </div>
              <ul>
                <li>
                  <div class="fifth" style="background-color:{{ !empty($lvl5_right_A['left']['color']) ? $lvl5_right_A['left']['color'] :'#ddd';  }}">
                    <div class="numbering">18</div>
                      @if(!empty($lvl5_right_A['left']))
                    <img src="{{ url($lvl5_right_A['left']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_A['left']['currentUser']->code->account_id).'-'.$lvl5_right_A['left']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl5_right_A['left']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl5_right_A['left']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl5_right_A['left']['currentUser']->code->type != 'Package C')
                        <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_A['left']['currentUser']->user->id}}">UPGRADE</a>     
                    @endif
                    @else
                       @if(!empty($lvl4_left_A['right']))
                              <?php
                                  $uplineId = $lvl4_left_A['right']['currentUser']->code->account_id;
                                  $sponsorId = $theUser->account->code->account_id;
                                  $theusername = $theUser->username;
                                  $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                              ?>
                               <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                              <div class="owner-info">
                                  <div class="owner-id">----------</div>
                                  <div class="owner-name">------------</div>
                              </div>
                              <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                       @else
                          <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------</div>
                              <div class="owner-name">------------</div>
                          </div>
                       @endif
                     @endif
                  </div>
                </li>
                <li>
                  <div class="fifth" style="background-color:{{ !empty($lvl5_right_A['right']['color']) ? $lvl5_right_A['right']['color'] :'#ddd';  }}">
                    <div class="numbering">19</div>
                      @if(!empty($lvl5_right_A['right']))
                    <img src="{{ url($lvl5_right_A['right']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_A['right']['currentUser']->code->account_id).'-'.$lvl5_right_A['right']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl5_right_A['right']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl5_right_A['right']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl5_right_A['right']['currentUser']->code->type != 'Package C')
                         <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_A['right']['currentUser']->user->id}}">UPGRADE</a>   
                    @endif
                    @else
                       @if(!empty($lvl4_left_A['right']))
                              <?php
                                  $uplineId = $lvl4_left_A['right']['currentUser']->code->account_id;
                                  $sponsorId = $theUser->account->code->account_id;
                                  $theusername = $theUser->username;
                                  $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                              ?>
                               <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                              <div class="owner-info">
                                  <div class="owner-id">----------</div>
                                  <div class="owner-name">------------</div>
                              </div>
                              <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                       @else
                          <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                          <div class="owner-info">
                              <div class="owner-id">----------</div>
                              <div class="owner-name">------------</div>
                          </div>
                       @endif
                     @endif
                  </div>
                </li>
              </ul>
            </li>
          </ul>
          </li>
          <li>
            <div class="third-fourth" style="background-color:{{ !empty($lvl3_left['right']['color']) ? $lvl3_left['right']['color'] :'#ddd';  }}">
              <div class="numbering">5</div>
               @if(!empty($lvl3_left['right']))
                <img src="{{ url($lvl3_left['right']['currentUser']->user->details->thePhoto) }}">
                <div class="owner-info">
                  <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_left['right']['currentUser']->code->account_id).'-'.$lvl3_left['right']['currentUser']->user->id)}}">
                    <div class="owner-id">ID: {{ $lvl3_left['right']['currentUser']->code->account_id  }}</div>
                    <div class="owner-name">{{ $lvl3_left['right']['currentUser']->user->details->fullName  }}</div>
                  </a>
               </div>
                @if($lvl3_left['right']['currentUser']->code->type != 'Package C')
                     <a href="#" class="button upgrade_button" data-id="{{ $lvl3_left['right']['currentUser']->user->id}}">UPGRADE</a>      
              @endif
              @else
                 @if(!empty($lvl2['left']))
                        <?php
                            $uplineId = $lvl2['left']['currentUser']->code->account_id;
                            $sponsorId = $theUser->account->code->account_id;
                            $theusername = $theUser->username;
                            $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                        ?>
                         <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">----------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                        <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                 @else
                    <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                    <div class="owner-info">
                        <div class="owner-id">----------------------</div>
                        <div class="owner-name">------------------------</div>
                    </div>
                 @endif
             @endif
            </div>
            <ul>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_right_A['left']['color']) ? $lvl4_right_A['left']['color'] :'#ddd';  }}">
                   <div class="numbering">10</div>
                   @if(!empty($lvl4_right_A['left']))
                     <img src="{{ url($lvl4_right_A['left']['currentUser']->user->details->thePhoto) }}">
                     <div class="owner-info">
                       <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_A['left']['currentUser']->code->account_id).'-'.$lvl4_right_A['left']['currentUser']->user->id)}}">
                         <div class="owner-id">ID: {{ $lvl4_right_A['left']['currentUser']->code->account_id  }}</div>
                         <div class="owner-name">{{ $lvl4_right_A['left']['currentUser']->user->details->fullName  }}</div>
                       </a>
                    </div>
                     @if($lvl4_right_A['left']['currentUser']->code->type != 'Package C')
                         <a href="#" class="button upgrade_button" data-id="{{ $lvl4_right_A['left']['currentUser']->user->id}}">UPGRADE</a>      
                   @endif
                   @else
                      @if(!empty($lvl3_left['right']))
                             <?php
                                 $uplineId = $lvl3_left['right']['currentUser']->code->account_id;
                                 $sponsorId = $theUser->account->code->account_id;
                                 $theusername = $theUser->username;
                                 $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                             ?>
                             <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                             <div class="owner-info">
                                 <div class="owner-id">----------------------</div>
                                 <div class="owner-name">------------------------</div>
                             </div>
                             <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                      @else
                         <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                         <div class="owner-info">
                             <div class="owner-id">----------------------</div>
                             <div class="owner-name">------------------------</div>
                         </div>
                      @endif
                  @endif
                 </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_B['left']['color']) ? $lvl5_left_B['left']['color'] :'#ddd';  }}">
                      <div class="numbering">20</div>
                      @if(!empty($lvl5_left_B['left']))
                      <img src="{{ url($lvl5_left_B['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_B['left']['currentUser']->code->account_id).'-'.$lvl5_left_B['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_B['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_B['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_B['left']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_B['left']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_right_A['left']))
                                <?php
                                    $uplineId = $lvl4_right_A['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_B['right']['color']) ? $lvl5_left_B['right']['color'] :'#ddd';  }}">
                      <div class="numbering">21</div>
                        @if(!empty($lvl5_left_B['right']))
                      <img src="{{ url($lvl5_left_B['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_B['right']['currentUser']->code->account_id).'-'.$lvl5_left_B['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_B['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_B['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_B['right']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_B['right']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_right_A['left']))
                                <?php
                                    $uplineId = $lvl4_right_A['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_right_A['right']['color']) ? $lvl4_right_A['right']['color'] :'#ddd';  }}">
                   <div class="numbering">11</div>
                   @if(!empty($lvl4_right_A['right']))
                     <img src="{{ url($lvl4_right_A['right']['currentUser']->user->details->thePhoto) }}">
                     <div class="owner-info">
                       <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_A['right']['currentUser']->code->account_id).'-'.$lvl4_right_A['right']['currentUser']->user->id)}}">
                         <div class="owner-id">ID: {{ $lvl4_right_A['right']['currentUser']->code->account_id  }}</div>
                         <div class="owner-name">{{ $lvl4_right_A['right']['currentUser']->user->details->fullName  }}</div>
                       </a>
                    </div>
                     @if($lvl4_right_A['right']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl4_right_A['right']['currentUser']->user->id}}">UPGRADE</a>      
                   @endif
                   @else
                    @if(!empty($lvl3_left['right']))
                           <?php
                               $uplineId = $lvl3_left['right']['currentUser']->code->account_id;
                               $sponsorId = $theUser->account->code->account_id;
                               $theusername = $theUser->username;
                               $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                           ?>
                           <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                           <div class="owner-info">
                               <div class="owner-id">----------------------</div>
                               <div class="owner-name">------------------------</div>
                           </div>
                           <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                    @else
                       <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                       <div class="owner-info">
                           <div class="owner-id">----------------------</div>
                           <div class="owner-name">------------------------</div>
                       </div>
                    @endif
                    @endif
                </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_B['left']['color']) ? $lvl5_right_B['left']['color'] :'#ddd';  }}">
                      <div class="numbering">22</div>
                      @if(!empty($lvl5_right_B['left']))
                      <img src="{{ url($lvl5_right_B['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_B['left']['currentUser']->code->account_id).'-'.$lvl5_right_B['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_B['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_B['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_B['left']['currentUser']->code->type != 'Package C')
                            <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_B['left']['currentUser']->user->id}}">UPGRADE</a>    
                      @endif
                      @else
                         @if(!empty($lvl4_right_A['right']))
                                <?php
                                    $uplineId = $lvl4_right_A['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_B['right']['color']) ? $lvl5_right_B['right']['color'] :'#ddd';  }}">
                      <div class="numbering">23</div>
                      @if(!empty($lvl5_right_B['right']))
                      <img src="{{ url($lvl5_right_B['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_B['right']['currentUser']->code->account_id).'-'.$lvl5_right_B['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_B['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_B['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_B['right']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_B['right']['currentUser']->user->id}}">UPGRADE</a>    
                      @endif
                      @else
                         @if(!empty($lvl4_right_A['right']))
                                <?php
                                    $uplineId = $lvl4_right_A['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li>
        <div class="first-second" style="background-color:{{ !empty($lvl2['right']['color']) ? $lvl2['right']['color'] :'#ddd';}}">
          <div class="numbering">3</div>
          @if(!empty($lvl2['right']))
          <img src="{{ url($lvl2['right']['currentUser']->user->details->thePhoto) }}">
          <div class="owner-info">
            <a href="{{url('member/network-tree/index/'.strtoupper($lvl2['right']['currentUser']->code->account_id).'-'.$lvl2['right']['currentUser']->user->id)}}">
              <div class="owner-id">ID: {{ $lvl2['right']['currentUser']->code->account_id  }}</div>
              <div class="owner-name">{{ $lvl2['right']['currentUser']->user->details->fullName  }}</div>
            </a>
          </div>
          @if($lvl2['right']['currentUser']->code->type != 'Package C')
               <a href="#" class="button upgrade_button" data-id="{{ $lvl2['right']['currentUser']->user->id}}">UPGRADE</a>      
          @endif
          @else
                 @if(!empty($account_id))
                        <?php
                            $uplineId = $currentUser->account->code->account_id;
                            $sponsorId = $theUser->account->code->account_id;
                            $theusername = $theUser->username;
                            $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                        ?>
                         <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">--------------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                        <!--<a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>-->
                        <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                 @else
                    <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                    <div class="owner-info">
                        <div class="owner-id">--------------------------</div>
                        <div class="owner-name">------------------------</div>
                    </div>
                 @endif
         @endif
        </div>
        <ul>
          <li>
            <div class="third-fourth" style="background-color:{{ !empty($lvl3_right['left']['color']) ? $lvl3_right['left']['color'] :'#ddd';}}">
              <div class="numbering">6</div>
                @if(!empty($lvl3_right['left']))
              <img src="{{ url($lvl3_right['left']['currentUser']->user->details->thePhoto) }}">
              <div class="owner-info">
                 <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_right['left']['currentUser']->code->account_id).'-'.$lvl3_right['left']['currentUser']->user->id)}}">
                   <div class="owner-id">ID: {{ $lvl3_right['left']['currentUser']->code->account_id  }}</div>
                   <div class="owner-name">{{ $lvl3_right['left']['currentUser']->user->details->fullName  }}</div>
                 </a>
              </div>
             @if($lvl3_right['left']['currentUser']->code->type != 'Package C')
                 <a href="#" class="button upgrade_button" data-id="{{ $lvl3_right['left']['currentUser']->user->id}}">UPGRADE</a>       
             @endif
             @else
                @if(!empty($lvl2['right']))
                       <?php
                           $uplineId = $lvl2['right']['currentUser']->code->account_id;
                           $sponsorId = $theUser->account->code->account_id;
                           $theusername = $theUser->username;
                           $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                       ?>
                        <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                       <div class="owner-info">
                           <div class="owner-id">----------------------</div>
                           <div class="owner-name">------------------------</div>
                       </div>
                       <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                @else
                   <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                   <div class="owner-info">
                       <div class="owner-id">----------------------</div>
                       <div class="owner-name">------------------------</div>
                   </div>
                @endif
              @endif
            </div>
            <ul>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_left_B['left']['color']) ? $lvl4_left_B['left']['color'] :'#ddd';}}">
                  <div class="numbering">12</div>
                  @if(!empty($lvl4_left_B['left']))
                    <img src="{{ url($lvl4_left_B['left']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_B['left']['currentUser']->code->account_id).'-'.$lvl4_left_B['left']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl4_left_B['left']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl4_left_B['left']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl4_left_B['left']['currentUser']->code->type != 'Package C')
                       <a href="#" class="button upgrade_button" data-id="{{ $lvl4_left_B['left']['currentUser']->user->id}}">UPGRADE</a>     
                  @endif
                  @else
                     @if(!empty($lvl3_right['left']))
                            <?php
                                $uplineId = $lvl3_right['left']['currentUser']->code->account_id;
                                $sponsorId = $theUser->account->code->account_id;
                                $theusername = $theUser->username;
                                $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                            ?>
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------------------</div>
                                <div class="owner-name">------------------------</div>
                            </div>
                            <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                     @else
                        <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">----------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                     @endif
                 @endif
                </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_C['left']['color']) ? $lvl5_left_C['left']['color'] :'#ddd';}}">
                      <div class="numbering">24</div>
                        @if(!empty($lvl5_left_C['left']))
                      <img src="{{ url($lvl5_left_C['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_C['left']['currentUser']->code->account_id).'-'.$lvl5_left_C['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_C['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_C['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_C['left']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_C['left']['currentUser']->user->id}}">UPGRADE</a>      
                      @endif
                      @else
                         @if(!empty($lvl4_left_B['left']))
                                <?php
                                    $uplineId = $lvl4_left_B['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_C['right']['color']) ? $lvl5_left_C['right']['color'] :'#ddd';}}">
                      <div class="numbering">25</div>
                      @if(!empty($lvl5_left_C['right']))
                      <img src="{{ url($lvl5_left_C['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_C['right']['currentUser']->code->account_id).'-'.$lvl5_left_C['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_C['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_C['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_C['right']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_C['right']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_left_B['left']))
                                <?php
                                    $uplineId = $lvl4_left_B['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_left_B['right']['color']) ? $lvl4_left_B['right']['color'] :'#ddd';}}">
                  <div class="numbering">13</div>
                   @if(!empty($lvl4_left_B['right']))
                    <img src="{{ url($lvl4_left_B['right']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_B['right']['currentUser']->code->account_id).'-'.$lvl4_left_B['right']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl4_left_B['right']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl4_left_B['right']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl4_left_B['right']['currentUser']->code->type != 'Package C')
                        <a href="#" class="button upgrade_button" data-id="{{ $lvl4_left_B['right']['currentUser']->user->id}}">UPGRADE</a>
                  @endif
                  @else
                     @if(!empty($lvl3_right['left']))
                            <?php
                                $uplineId = $lvl3_right['left']['currentUser']->code->account_id;
                                $sponsorId = $theUser->account->code->account_id;
                                $theusername = $theUser->username;
                                $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                            ?>
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------------------</div>
                                <div class="owner-name">------------------------</div>
                            </div>
                            <!-- <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>-->
                            <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                     @else
                        <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">----------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                     @endif
                 @endif
                </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_C['left']['color']) ? $lvl5_right_C['left']['color'] :'#ddd';}}">
                      <div class="numbering">26</div>
                      @if(!empty($lvl5_right_C['left']))
                      <img src="{{ url($lvl5_right_C['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_C['left']['currentUser']->code->account_id).'-'.$lvl5_right_C['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_C['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_C['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_C['left']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_C['left']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_left_B['right']))
                                <?php
                                    $uplineId = $lvl4_left_B['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_C['right']['color']) ? $lvl5_right_C['right']['color'] :'#ddd';}}">
                      <div class="numbering">27</div>
                      @if(!empty($lvl5_right_C['right']))
                      <img src="{{ url($lvl5_right_C['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_C['right']['currentUser']->code->account_id).'-'.$lvl5_right_C['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_C['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_C['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_C['right']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_C['right']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_left_B['right']))
                                <?php
                                    $uplineId = $lvl4_left_B['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <div class="third-fourth" style="background-color:{{ !empty($lvl3_right['right']['color']) ? $lvl3_right['right']['color'] :'#ddd';}}">
              <div class="numbering">7</div>
              @if(!empty($lvl3_right['right']))
                <img src="{{ url($lvl3_right['right']['currentUser']->user->details->thePhoto) }}">
                <div class="owner-info">
                  <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_right['right']['currentUser']->code->account_id).'-'.$lvl3_right['right']['currentUser']->user->id)}}">
                    <div class="owner-id">ID: {{ $lvl3_right['right']['currentUser']->code->account_id  }}</div>
                    <div class="owner-name">{{ $lvl3_right['right']['currentUser']->user->details->fullName  }}</div>
                  </a>
                </div>
                @if($lvl3_right['right']['currentUser']->code->type != 'Package C')
                     <a href="#" class="button upgrade_button" data-id="{{ $lvl3_right['right']['currentUser']->user->id}}">UPGRADE</a>    
                @endif
                @else
                   @if(!empty($lvl2['right']))
                      <?php
                          $uplineId = $lvl2['right']['currentUser']->code->account_id;
                          $sponsorId = $theUser->account->code->account_id;
                          $theusername = $theUser->username;
                          $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                      ?>
                       <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                      <div class="owner-info">
                          <div class="owner-id">----------------------</div>
                          <div class="owner-name">------------------------</div>
                      </div>
                      <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                   @else
                      <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                      <div class="owner-info">
                          <div class="owner-id">----------------------</div>
                          <div class="owner-name">------------------------</div>
                      </div>
                   @endif
               @endif
            </div>
            <ul>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_right_B['left']['color']) ? $lvl4_right_B['left']['color'] :'#ddd';}}">
                  <div class="numbering">14</div>
                  @if(!empty($lvl4_right_B['left']))
                    <img src="{{ url($lvl4_right_B['left']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_B['left']['currentUser']->code->account_id).'-'.$lvl4_right_B['left']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl4_right_B['left']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl4_right_B['left']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl4_right_B['left']['currentUser']->code->type != 'Package C')
                        <a href="#" class="button upgrade_button" data-id="{{ $lvl4_right_B['left']['currentUser']->user->id}}">UPGRADE</a> 
                  @endif
                  @else
                     @if(!empty($lvl3_right['right']))
                            <?php
                                $uplineId = $lvl3_right['right']['currentUser']->code->account_id;
                                $sponsorId = $theUser->account->code->account_id;
                                $theusername = $theUser->username;
                                $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                            ?>
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------------------</div>
                                <div class="owner-name">------------------------</div>
                            </div>
                            <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                     @else
                        <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">----------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                     @endif
                 @endif
                </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_D['left']['color']) ? $lvl5_left_D['left']['color'] :'#ddd';}}">
                      <div class="numbering">28</div>
                      @if(!empty($lvl5_left_D['left']))
                      <img src="{{ url($lvl5_left_D['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_D['left']['currentUser']->code->account_id).'-'.$lvl5_left_D['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_D['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_D['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_D['left']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_D['left']['currentUser']->user->id}}">UPGRADE</a>    
                      @endif
                      @else
                         @if(!empty($lvl4_right_B['left']))
                                <?php
                                    $uplineId = $lvl4_right_B['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_left_D['right']['color']) ? $lvl5_left_D['right']['color'] :'#ddd';}}">
                      <div class="numbering">29</div>
                      @if(!empty($lvl5_left_D['right']))
                      <img src="{{ url($lvl5_left_D['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_D['right']['currentUser']->code->account_id).'-'.$lvl5_left_D['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_left_D['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_left_D['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_left_D['right']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_left_D['right']['currentUser']->user->id}}">UPGRADE</a>     
                      @endif
                      @else
                         @if(!empty($lvl4_right_B['left']))
                                <?php
                                    $uplineId = $lvl4_right_B['left']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                <div class="third-fourth" style="background-color:{{ !empty($lvl4_right_B['right']['color']) ? $lvl4_right_B['right']['color'] :'#ddd';}}">
                  <div class="numbering">15</div>
                  @if(!empty($lvl4_right_B['right']))
                    <img src="{{ url($lvl4_right_B['right']['currentUser']->user->details->thePhoto) }}">
                    <div class="owner-info">
                      <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_B['right']['currentUser']->code->account_id).'-'.$lvl4_right_B['right']['currentUser']->user->id)}}">
                        <div class="owner-id">ID: {{ $lvl4_right_B['right']['currentUser']->code->account_id  }}</div>
                        <div class="owner-name">{{ $lvl4_right_B['right']['currentUser']->user->details->fullName  }}</div>
                      </a>
                   </div>
                    @if($lvl4_right_B['right']['currentUser']->code->type != 'Package C')
                         <a href="#" class="button upgrade_button" data-id="{{ $lvl4_right_B['right']['currentUser']->user->id}}">UPGRADE</a>
                  @endif
                  @else
                     @if(!empty($lvl3_right['right']))
                            <?php
                                $uplineId = $lvl3_right['right']['currentUser']->code->account_id;
                                $sponsorId = $theUser->account->code->account_id;
                                $theusername = $theUser->username;
                                $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                            ?>
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------------------</div>
                                <div class="owner-name">------------------------</div>
                            </div>
                            <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                     @else
                        <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                        <div class="owner-info">
                            <div class="owner-id">----------------------</div>
                            <div class="owner-name">------------------------</div>
                        </div>
                     @endif
                 @endif
                </div>
                <ul>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_D['left']['color']) ? $lvl5_right_D['left']['color'] :'#ddd';}}">
                      <div class="numbering">30</div>
                      @if(!empty($lvl5_right_D['left']))
                      <img src="{{ url($lvl5_right_D['left']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_D['left']['currentUser']->code->account_id).'-'.$lvl5_right_D['left']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_D['left']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_D['left']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_D['left']['currentUser']->code->type != 'Package C')
                          <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_D['left']['currentUser']->user->id}}">UPGRADE</a>    
                      @endif
                      @else
                         @if(!empty($lvl4_right_B['right']))
                                <?php
                                    $uplineId = $lvl4_right_B['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=left&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="left">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                  <li>
                    <div class="fifth" style="background-color:{{ !empty($lvl5_right_D['right']['color']) ? $lvl5_right_D['right']['color'] :'#ddd';}}">
                      <div class="numbering">31</div>
                      @if(!empty($lvl5_right_D['right']))
                      <img src="{{ url($lvl5_right_D['right']['currentUser']->user->details->thePhoto) }}">
                      <div class="owner-info">
                        <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_D['right']['currentUser']->code->account_id).'-'.$lvl5_right_D['right']['currentUser']->user->id)}}">
                          <div class="owner-id">ID: {{ $lvl5_right_D['right']['currentUser']->code->account_id  }}</div>
                          <div class="owner-name">{{ $lvl5_right_D['right']['currentUser']->user->details->fullName  }}</div>
                        </a>
                     </div>
                      @if($lvl5_right_D['right']['currentUser']->code->type != 'Package C')
                           <a href="#" class="button upgrade_button" data-id="{{ $lvl5_right_D['right']['currentUser']->user->id}}">UPGRADE</a>      
                      @endif
                      @else
                         @if(!empty($lvl4_right_B['right']))
                                <?php
                                    $uplineId = $lvl4_right_B['right']['currentUser']->code->account_id;
                                    $sponsorId = $theUser->account->code->account_id;
                                    $theusername = $theUser->username;
                                    $url = "/auth/sign-up?uplineid={$uplineId}&sponsorid={$sponsorId}&node=right&theusername={$theusername}";
                                ?>
                                 <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                                <div class="owner-info">
                                    <div class="owner-id">----------</div>
                                    <div class="owner-name">------------</div>
                                </div>
                                <a href="#" class="button activate_button" data-upline="{{ $uplineId }}" data-node="right">ACTIVATE</a>
                         @else
                            <img src="{{ asset('public/custom/images/default_user.jpg') }}">
                            <div class="owner-info">
                                <div class="owner-id">----------</div>
                                <div class="owner-name">------------</div>
                            </div>
                         @endif
                       @endif
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</ul>
