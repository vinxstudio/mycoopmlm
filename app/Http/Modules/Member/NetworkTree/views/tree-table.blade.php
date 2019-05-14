<table class="table table-bordered table-striped table-primary" id="list-table">
  <thead>
    <tr>
      <th>No.</th>
      <th>Account ID.</th>
      <th>Name</th>
      <th>Sponsor Name</th>
      <th>Account Package</th>
      <th>LPV</th>
      <th>RPV</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>1.</strong></td>
      <td>{{$currentUser->account->code->account_id.'-'.$currentUser->id}}</td>
      <td>{{ $currentUser->details->fullName }}</td>
      <td>{{ !empty($sponsor) ? $sponsor->first_name.' '.$sponsor->last_name.' ('.$sponsor->account_id.')' : '------------------------------' }}</td>
      <td>{{ $currentUser->account->code->type }}</td>
      <td>{{ $countLPV }}</td>
      <td>{{ $countRPV }}</td>
    </tr>
    <tr>
      <td><strong>2.</strong></td>
      <td>
         @if (!empty($lvl2['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl2['left']['currentUser']->code->account_id).'-'.$lvl2['left']['currentUser']->user->id)}}">
               {{$lvl2['left']['currentUser']->code->account_id.'-'.$lvl2['left']['currentUser']->user->id  }}             
           </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl2['left']) ? $lvl2['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
     <td>{{ !empty($lvl2['left']) ? $lvl2['left']['sponsor']->first_name.' '.$lvl2['left']['sponsor']->last_name.' ('.$lvl2['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl2['left']) ? $lvl2['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl2['left']) ? $lvl2['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl2['left']) ? $lvl2['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>3.</strong></td>
      <td>
         @if (!empty($lvl2['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl2['right']['currentUser']->code->account_id).'-'.$lvl2['right']['currentUser']->user->id)}}">
               {{$lvl2['right']['currentUser']->code->account_id.'-'.$lvl2['right']['currentUser']->user->id  }}             
           </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl2['right']) ? $lvl2['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl2['right']) ? $lvl2['right']['sponsor']->first_name.' '.$lvl2['right']['sponsor']->last_name.' ('.$lvl2['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl2['right']) ? $lvl2['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl2['right']) ? $lvl2['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl2['right']) ? $lvl2['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>4.</strong></td>
      <td>
         @if (!empty($lvl3_left['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_left['left']['currentUser']->code->account_id).'-'.$lvl3_left['left']['currentUser']->user->id)}}">
               {{$lvl3_left['left']['currentUser']->code->account_id.'-'.$lvl3_left['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl3_left['left']) ? $lvl3_left['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_left['left']) ? $lvl3_left['left']['sponsor']->first_name.' '.$lvl3_left['left']['sponsor']->last_name.' ('.$lvl3_left['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_left['left']) ? $lvl3_left['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl3_left['left']) ? $lvl3_left['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl3_left['left']) ? $lvl3_left['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>5.</strong></td>
      <td>
         @if (!empty($lvl3_left['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_left['right']['currentUser']->code->account_id).'-'.$lvl3_left['right']['currentUser']->user->id)}}">
               {{$lvl3_left['right']['currentUser']->code->account_id.'-'.$lvl3_left['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl3_left['right']) ? $lvl3_left['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_left['right']) ? $lvl3_left['right']['sponsor']->first_name.' '.$lvl3_left['right']['sponsor']->last_name.' ('.$lvl3_left['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_left['right']) ? $lvl3_left['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl3_left['right']) ? $lvl3_left['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl3_left['right']) ? $lvl3_left['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>6.</strong></td>
      <td>
         @if (!empty($lvl3_right['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_right['left']['currentUser']->code->account_id).'-'.$lvl3_right['left']['currentUser']->user->id)}}">
               {{$lvl3_right['left']['currentUser']->code->account_id.'-'.$lvl3_right['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl3_right['left']) ? $lvl3_right['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_right['left']) ? $lvl3_right['left']['sponsor']->first_name.' '.$lvl3_right['left']['sponsor']->last_name.' ('.$lvl3_right['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_right['left']) ? $lvl3_right['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl3_right['left']) ? $lvl3_right['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl3_right['left']) ? $lvl3_right['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>7.</strong></td>
      <td>
         @if (!empty($lvl3_right['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl3_right['right']['currentUser']->code->account_id).'-'.$lvl3_right['right']['currentUser']->user->id)}}">
               {{$lvl3_right['right']['currentUser']->code->account_id.'-'.$lvl3_right['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl3_right['right']) ? $lvl3_right['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_right['right']) ? $lvl3_right['right']['sponsor']->first_name.' '.$lvl3_right['right']['sponsor']->last_name.' ('.$lvl3_right['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl3_right['right']) ? $lvl3_right['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl3_right['right']) ? $lvl3_right['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl3_right['right']) ? $lvl3_right['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>8.</strong></td>
      <td>
         @if (!empty($lvl4_left_A['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_A['left']['currentUser']->code->account_id).'-'.$lvl4_left_A['left']['currentUser']->user->id)}}">
               {{$lvl4_left_A['left']['currentUser']->code->account_id.'-'.$lvl4_left_A['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_left_A['left']) ? $lvl4_left_A['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_A['left']) ? $lvl4_left_A['left']['sponsor']->first_name.' '.$lvl4_left_A['left']['sponsor']->last_name.' ('.$lvl4_left_A['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_A['left']) ? $lvl4_left_A['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_left_A['left']) ? $lvl4_left_A['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_left_A['left']) ? $lvl4_left_A['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>9.</strong></td>
      <td>
         @if (!empty($lvl4_left_A['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_A['right']['currentUser']->code->account_id).'-'.$lvl4_left_A['right']['currentUser']->user->id)}}">
               {{$lvl4_left_A['right']['currentUser']->code->account_id.'-'.$lvl4_left_A['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_left_A['right']) ? $lvl4_left_A['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_A['right']) ? $lvl4_left_A['right']['sponsor']->first_name.' '.$lvl4_left_A['right']['sponsor']->last_name.' ('.$lvl4_left_A['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_A['right']) ? $lvl4_left_A['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_left_A['right']) ? $lvl4_left_A['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_left_A['right']) ? $lvl4_left_A['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>10.</strong></td>
      <td>
         @if (!empty($lvl4_right_A['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_A['left']['currentUser']->code->account_id).'-'.$lvl4_right_A['left']['currentUser']->user->id)}}">
               {{$lvl4_right_A['left']['currentUser']->code->account_id.'-'.$lvl4_right_A['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_right_A['left']) ? $lvl4_right_A['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_A['left']) ? $lvl4_right_A['left']['sponsor']->first_name.' '.$lvl4_right_A['left']['sponsor']->last_name.' ('.$lvl4_right_A['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_A['left']) ? $lvl4_right_A['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_right_A['left']) ? $lvl4_right_A['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_right_A['left']) ? $lvl4_right_A['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>11.</strong></td>
      <td>
         @if (!empty($lvl4_right_A['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_A['right']['currentUser']->code->account_id).'-'.$lvl4_right_A['right']['currentUser']->user->id)}}">
               {{$lvl4_right_A['right']['currentUser']->code->account_id.'-'.$lvl4_right_A['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_right_A['right']) ? $lvl4_right_A['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_A['right']) ? $lvl4_right_A['right']['sponsor']->first_name.' '.$lvl4_right_A['right']['sponsor']->last_name.' ('.$lvl4_right_A['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_A['right']) ? $lvl4_right_A['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_right_A['right']) ? $lvl4_right_A['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_right_A['right']) ? $lvl4_right_A['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>12.</strong></td>
      <td>
         @if (!empty($lvl4_left_B['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_B['left']['currentUser']->code->account_id).'-'.$lvl4_left_B['left']['currentUser']->user->id)}}">
               {{$lvl4_left_B['left']['currentUser']->code->account_id.'-'.$lvl4_left_B['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_left_B['left']) ? $lvl4_left_B['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_B['left']) ? $lvl4_left_B['left']['sponsor']->first_name.' '.$lvl4_left_B['left']['sponsor']->last_name.' ('.$lvl4_left_B['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_B['left']) ? $lvl4_left_B['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_left_B['left']) ? $lvl4_left_B['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_left_B['left']) ? $lvl4_left_B['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>13.</strong></td>
      <td>
         @if (!empty($lvl4_left_B['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_left_B['right']['currentUser']->code->account_id).'-'.$lvl4_left_B['right']['currentUser']->user->id)}}">
               {{$lvl4_left_B['right']['currentUser']->code->account_id.'-'.$lvl4_left_B['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_left_B['right']) ? $lvl4_left_B['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_B['right']) ? $lvl4_left_B['right']['sponsor']->first_name.' '.$lvl4_left_B['right']['sponsor']->last_name.' ('.$lvl4_left_B['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_left_B['right']) ? $lvl4_left_B['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_left_B['right']) ? $lvl4_left_B['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_left_B['right']) ? $lvl4_left_B['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>14.</strong></td>
      <td>
         @if (!empty($lvl4_right_B['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_B['left']['currentUser']->code->account_id).'-'.$lvl4_right_B['left']['currentUser']->user->id)}}">
               {{$lvl4_right_B['left']['currentUser']->code->account_id.'-'.$lvl4_right_B['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_right_B['left']) ? $lvl4_right_B['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_B['left']) ? $lvl4_right_B['left']['sponsor']->first_name.' '.$lvl4_right_B['left']['sponsor']->last_name.' ('.$lvl4_right_B['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_B['left']) ? $lvl4_right_B['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_right_B['left']) ? $lvl4_right_B['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_right_B['left']) ? $lvl4_right_B['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>15.</strong></td>
      <td>
         @if (!empty($lvl4_right_B['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl4_right_B['right']['currentUser']->code->account_id).'-'.$lvl4_right_B['right']['currentUser']->user->id)}}">
               {{$lvl4_right_B['right']['currentUser']->code->account_id.'-'.$lvl4_right_B['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl4_right_B['right']) ? $lvl4_right_B['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_B['right']) ? $lvl4_right_B['right']['sponsor']->first_name.' '.$lvl4_right_B['right']['sponsor']->last_name.' ('.$lvl4_right_B['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl4_right_B['right']) ? $lvl4_right_B['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl4_right_B['right']) ? $lvl4_right_B['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl4_right_B['right']) ? $lvl4_right_B['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>16.</strong></td>
      <td>
         @if (!empty($lvl5_left_A['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_A['left']['currentUser']->code->account_id).'-'.$lvl5_left_A['left']['currentUser']->user->id)}}">
               {{$lvl5_left_A['left']['currentUser']->code->account_id.'-'.$lvl5_left_A['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_A['left']) ? $lvl5_left_A['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_A['left']) ? $lvl5_left_A['left']['sponsor']->first_name.' '.$lvl5_left_A['left']['sponsor']->last_name.' ('.$lvl5_left_A['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_A['left']) ? $lvl5_left_A['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_A['left']) ? $lvl5_left_A['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_A['left']) ? $lvl5_left_A['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>17.</strong></td>
      <td>
         @if (!empty($lvl5_left_A['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_A['right']['currentUser']->code->account_id).'-'.$lvl5_left_A['right']['currentUser']->user->id)}}">
               {{$lvl5_left_A['right']['currentUser']->code->account_id.'-'.$lvl5_left_A['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_A['right']) ? $lvl5_left_A['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_A['right']) ? $lvl5_left_A['right']['sponsor']->first_name.' '.$lvl5_left_A['right']['sponsor']->last_name.' ('.$lvl5_left_A['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_A['right']) ? $lvl5_left_A['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_A['right']) ? $lvl5_left_A['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_A['right']) ? $lvl5_left_A['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>18.</strong></td>
      <td>
         @if (!empty($lvl5_right_A['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_A['left']['currentUser']->code->account_id).'-'.$lvl5_right_A['left']['currentUser']->user->id)}}">
               {{$lvl5_right_A['left']['currentUser']->code->account_id.'-'.$lvl5_right_A['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_A['left']) ? $lvl5_right_A['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_A['left']) ? $lvl5_right_A['left']['sponsor']->first_name.' '.$lvl5_right_A['left']['sponsor']->last_name.' ('.$lvl5_right_A['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_A['left']) ? $lvl5_right_A['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_A['left']) ? $lvl5_right_A['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_A['left']) ? $lvl5_right_A['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>19.</strong></td>
      <td>
         @if (!empty($lvl5_right_A['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_A['right']['currentUser']->code->account_id).'-'.$lvl5_right_A['right']['currentUser']->user->id)}}">
               {{$lvl5_right_A['right']['currentUser']->code->account_id.'-'.$lvl5_right_A['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_A['right']) ? $lvl5_right_A['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_A['right']) ? $lvl5_right_A['right']['sponsor']->first_name.' '.$lvl5_right_A['right']['sponsor']->last_name.' ('.$lvl5_right_A['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_A['right']) ? $lvl5_right_A['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_A['right']) ? $lvl5_right_A['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_A['right']) ? $lvl5_right_A['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>20.</strong></td>
      <td>
         @if (!empty($lvl5_left_B['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_B['left']['currentUser']->code->account_id).'-'.$lvl5_left_B['left']['currentUser']->user->id)}}">
               {{$lvl5_left_B['left']['currentUser']->code->account_id.'-'.$lvl5_left_B['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_B['left']) ? $lvl5_left_B['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_B['left']) ? $lvl5_left_B['left']['sponsor']->first_name.' '.$lvl5_left_B['left']['sponsor']->last_name.' ('.$lvl5_left_B['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_B['left']) ? $lvl5_left_B['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_B['left']) ? $lvl5_left_B['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_B['left']) ? $lvl5_left_B['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>21.</strong></td>
      <td>
         @if (!empty($lvl5_left_B['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_B['right']['currentUser']->code->account_id).'-'.$lvl5_left_B['right']['currentUser']->user->id)}}">
               {{$lvl5_left_B['right']['currentUser']->code->account_id.'-'.$lvl5_left_B['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_B['right']) ? $lvl5_left_B['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_B['right']) ? $lvl5_left_B['right']['sponsor']->first_name.' '.$lvl5_left_B['right']['sponsor']->last_name.' ('.$lvl5_left_B['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_B['right']) ? $lvl5_left_B['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_B['right']) ? $lvl5_left_B['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_B['right']) ? $lvl5_left_B['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>22.</strong></td>
      <td>
         @if (!empty($lvl5_right_B['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_B['left']['currentUser']->code->account_id).'-'.$lvl5_right_B['left']['currentUser']->user->id)}}">
               {{$lvl5_right_B['left']['currentUser']->code->account_id.'-'.$lvl5_right_B['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_B['left']) ? $lvl5_right_B['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_B['left']) ? $lvl5_right_B['left']['sponsor']->first_name.' '.$lvl5_right_B['left']['sponsor']->last_name.' ('.$lvl5_right_B['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_B['left']) ? $lvl5_right_B['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_B['left']) ? $lvl5_right_B['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_B['left']) ? $lvl5_right_B['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>23.</strong></td>
      <td>
         @if (!empty($lvl5_right_B['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_B['right']['currentUser']->code->account_id).'-'.$lvl5_right_B['right']['currentUser']->user->id)}}">
               {{$lvl5_right_B['right']['currentUser']->code->account_id.'-'.$lvl5_right_B['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_B['right']) ? $lvl5_right_B['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_B['right']) ? $lvl5_right_B['right']['sponsor']->first_name.' '.$lvl5_right_B['right']['sponsor']->last_name.' ('.$lvl5_right_B['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_B['right']) ? $lvl5_right_B['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_B['right']) ? $lvl5_right_B['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_B['right']) ? $lvl5_right_B['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>24.</strong></td>
      <td>
         @if (!empty($lvl5_left_C['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_C['left']['currentUser']->code->account_id).'-'.$lvl5_left_C['left']['currentUser']->user->id)}}">
               {{$lvl5_left_C['left']['currentUser']->code->account_id.'-'.$lvl5_left_C['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_C['left']) ? $lvl5_left_C['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_C['left']) ? $lvl5_left_C['left']['sponsor']->first_name.' '.$lvl5_left_C['left']['sponsor']->last_name.' ('.$lvl5_left_C['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_C['left']) ? $lvl5_left_C['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_C['left']) ? $lvl5_left_C['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_C['left']) ? $lvl5_left_C['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>25.</strong></td>
      <td>
         @if (!empty($lvl5_left_C['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_C['right']['currentUser']->code->account_id).'-'.$lvl5_left_C['right']['currentUser']->user->id)}}">
               {{$lvl5_left_C['right']['currentUser']->code->account_id.'-'.$lvl5_left_C['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_C['right']) ? $lvl5_left_C['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_C['right']) ? $lvl5_left_C['right']['sponsor']->first_name.' '.$lvl5_left_C['right']['sponsor']->last_name.' ('.$lvl5_left_C['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_C['right']) ? $lvl5_left_C['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_C['right']) ? $lvl5_left_C['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_C['right']) ? $lvl5_left_C['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>26.</strong></td>
      <td>
         @if (!empty($lvl5_left_C['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_C['right']['currentUser']->code->account_id).'-'.$lvl5_left_C['right']['currentUser']->user->id)}}">
               {{$lvl5_left_C['right']['currentUser']->code->account_id.'-'.$lvl5_left_C['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_C['left']) ? $lvl5_right_C['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_C['left']) ? $lvl5_right_C['left']['sponsor']->first_name.' '.$lvl5_right_C['left']['sponsor']->last_name.' ('.$lvl5_right_C['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_C['left']) ? $lvl5_right_C['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_C['left']) ? $lvl5_right_C['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_C['left']) ? $lvl5_right_C['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>27.</strong></td>
      <td>
         @if (!empty($lvl5_right_C['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_C['right']['currentUser']->code->account_id).'-'.$lvl5_right_C['right']['currentUser']->user->id)}}">
               {{$lvl5_right_C['right']['currentUser']->code->account_id.'-'.$lvl5_right_C['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_C['right']) ? $lvl5_right_C['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_C['right']) ? $lvl5_right_C['right']['sponsor']->first_name.' '.$lvl5_right_C['right']['sponsor']->last_name.' ('.$lvl5_right_C['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_C['right']) ? $lvl5_right_C['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_C['right']) ? $lvl5_right_C['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_C['right']) ? $lvl5_right_C['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>28.</strong></td>
      <td>
         @if (!empty($lvl5_left_D['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_D['left']['currentUser']->code->account_id).'-'.$lvl5_left_D['left']['currentUser']->user->id)}}">
               {{$lvl5_left_D['left']['currentUser']->code->account_id.'-'.$lvl5_left_D['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_D['left']) ? $lvl5_left_D['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_D['left']) ? $lvl5_left_D['left']['sponsor']->first_name.' '.$lvl5_left_D['left']['sponsor']->last_name.' ('.$lvl5_left_D['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_D['left']) ? $lvl5_left_D['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_D['left']) ? $lvl5_left_D['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_D['left']) ? $lvl5_left_D['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>29.</strong></td>
      <td>
         @if (!empty($lvl5_left_D['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_left_D['right']['currentUser']->code->account_id).'-'.$lvl5_left_D['right']['currentUser']->user->id)}}">
               {{$lvl5_left_D['right']['currentUser']->code->account_id.'-'.$lvl5_left_D['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_left_D['right']) ? $lvl5_left_D['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_D['right']) ? $lvl5_left_D['right']['sponsor']->first_name.' '.$lvl5_left_D['right']['sponsor']->last_name.' ('.$lvl5_left_D['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_left_D['right']) ? $lvl5_left_D['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_left_D['right']) ? $lvl5_left_D['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_left_D['right']) ? $lvl5_left_D['right']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>30.</strong></td>
      <td>
         @if (!empty($lvl5_right_D['left']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_D['left']['currentUser']->code->account_id).'-'.$lvl5_right_D['left']['currentUser']->user->id)}}">
               {{$lvl5_right_D['left']['currentUser']->code->account_id.'-'.$lvl5_right_D['left']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_D['left']) ? $lvl5_right_D['left']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_D['left']) ? $lvl5_right_D['left']['sponsor']->first_name.' '.$lvl5_right_D['left']['sponsor']->last_name.' ('.$lvl5_right_D['left']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_D['left']) ? $lvl5_right_D['left']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_D['left']) ? $lvl5_right_D['left']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_D['left']) ? $lvl5_right_D['left']['countRPV'] : ''}}</td>
    </tr>
    <tr>
      <td><strong>31.</strong></td>
      <td>
         @if (!empty($lvl5_right_D['right']))
           <a href="{{url('member/network-tree/index/'.strtoupper($lvl5_right_D['right']['currentUser']->code->account_id).'-'.$lvl5_right_D['right']['currentUser']->user->id)}}">
               {{$lvl5_right_D['right']['currentUser']->code->account_id.'-'.$lvl5_right_D['right']['currentUser']->user->id  }}
             </a>
         @else
           ------------------------------
         @endif
      </td>
      <td>{{ !empty($lvl5_right_D['right']) ? $lvl5_right_D['right']['currentUser']->user->details->fullName : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_D['right']) ? $lvl5_right_D['right']['sponsor']->first_name.' '.$lvl5_right_D['right']['sponsor']->last_name.' ('.$lvl5_right_D['right']['sponsor']->account_id.')' : '------------------------------' }}</td>
      <td>{{ !empty($lvl5_right_D['right']) ? $lvl5_right_D['right']['currentUser']->code->type : '------------------------------'}}</td>
      <td>{{ !empty($lvl5_right_D['right']) ? $lvl5_right_D['right']['countLPV'] : '' }}</td>
      <td>{{ !empty($lvl5_right_D['right']) ? $lvl5_right_D['right']['countRPV'] : ''}}</td>
    </tr>
  </tbody>
</table>
