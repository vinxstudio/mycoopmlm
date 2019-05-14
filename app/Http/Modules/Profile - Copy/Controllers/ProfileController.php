<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/11/17
 * Time: 3:53 PM
 */

namespace App\Http\Modules\Profile\Controllers;

use App\Http\AbstractHandlers\MainAbstract;
use App\Models\Company;
use App\Models\Details;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ProfileController extends MainAbstract{

    protected
        $layout = 'layouts.master',
        $viewpath = 'Profile.views.',
        $user,
        $maxFileSize = 1000000000
    ;

    function __construct(){
        parent::__construct();
        $this->user = Auth::user();
		// 1/16/2018
		$type = $this->user->member_type_id;
		$this->theMembership = Membership::find($type);
		
        if ($this->user->role == 'member'){
            $this->layout = 'layouts.members';
        }

        view()->share([
            'layout'=>$this->layout,
            'theUser'=>$this->user,
            'company'=>Company::find(1),
            'menus'=>($this->user->role == 'member') ? $this->memberMenus : $this->adminMenus,
			'member' =>$this->theMembership
        ]);
    }

    function getIndex(){

        return view( $this->viewpath . 'index' )
            ->with([
                'id'=>$this->user->id,
                'user'=>$this->user
            ]);

    }

    function postIndex(Request $request){

        if ($request->ajax()){

            $result = new \stdClass();
            $result->status = 'error';
            $result->message = '';

            if ($request->hasFile('file')){

                $file = $request->file('file');
                $size = $file->getClientSize();
                $extension = $file->getClientOriginalExtension();

                if ($size >= $this->maxFileSize){
                    $result->message = 'You have exceeded maximum file size allowed.';
                } else {
                    $newPathName = sprintf('%s%s.%s', time(), $this->user->id, $extension);
                    $file->move($this->upload_location, $newPathName);

                    $fullPath = sprintf('%s/%s', $this->upload_location, $newPathName);

                    $details = Details::find($this->user->user_details_id);

                    if (file_exists($details->photo)){
                        unlink($details->photo);
                    }

                    $details->photo = $fullPath;
                    $details->save();
                    $result->status = 'success';
                    $result->message = 'Photo successfully updated.';
                }

            }

            return response()->json($result);

        } else {
            $result = new \stdClass();
            $result->error = false;
            $result->message = '';

            $validation = $this->validateUserDetails($request);

            if ($validation->fails()) {
                $result->error = true;
            } else {
                $this->saveDetails($this->user->id, $request);
                $result->message = Lang::get('messages.saved');
            }

            return ($result->error) ? redirect($request->segment(1) . '/profile')
                ->withInput()
                ->withErrors($validation->errors())
                ->with('danger', $result->message) : redirect($request->segment(1) . '/profile')
                ->with('success', $result->message);
        }

    }


}