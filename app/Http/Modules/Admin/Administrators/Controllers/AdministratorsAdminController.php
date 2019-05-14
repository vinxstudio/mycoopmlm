<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 6/4/17
 * Time: 6:05 PM
 */

namespace App\Http\Modules\Admin\Administrators\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Details;
use App\Models\ModuleAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdministratorsAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Administrators.views.';
    protected $mainAdminID = 1;
    protected $adminRole = 'admin';

    function getIndex(){

        $admins = User::where([
            'role'=>$this->adminRole
        ])->where('id', '!=', $this->mainAdminID)->paginate($this->records_per_page);

        return view( $this->viewpath .'index' )->with([
            'admins'=>$admins
        ]);

    }

    function getForm($admin_id = 0){
        if ($admin_id == $this->mainAdminID){
            return redirect('admin/administrators');
        }
        view()->share([
            'formType'=>'admin'
        ]);
        return view( $this->viewpath . 'form' )->with([
            'formTitle'=>($admin_id > 0) ? 'Update Administrator Details' : 'Add New Administrator',
            'member_id'=>0,
            'id'=>$admin_id,
            'user'=>User::find($admin_id)
        ]);
    }

    function postForm(Request $request, $id = 0){
        $suffix = ($id > 0) ? ',username,'.$id : '';
        $detailsID = ($id > 0) ? User::find($id)->user_details_id : 0;
        $userDetailsSuffix = ($id > 0) ? ',email,'.$detailsID : '';

        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>sprintf('required|unique:users%s', $suffix),
            'email'=>sprintf('email|unique:user_details%s', $userDetailsSuffix),
        ];

        if ($request->password != null){
            $rules['password'] = 'required|min:8';
            $rules['password_confirm'] = 'required|same:password';
        }

        $validation = Validator::make($request->input(), $rules);

        $error = false;
        $message = null;

        if (!$validation->fails()){

//            DB::beginTransaction();
            try{

                $details = ($detailsID > 0) ? Details::find($detailsID) : new Details();
                $details->first_name = $request->first_name;
                $details->last_name = $request->last_name;
                $details->email = $request->email;
                $details->save();

                $user = ($id > 0) ? User::find($id) : new User();
                $user->username = $request->username;
                $user->password  = Hash::make($request->password);
                $user->role = $this->adminRole;
                $user->user_details_id = $details->id;
                $user->save();
                $error = false;

                if (count($request->modules) > 0){

                    $moduleAccess = [];
                    foreach ($request->modules as $module){
                        $moduleAccess[] = [
                            'user_id'=>$user->id,
                            'module_name'=>$module,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
                    }

                    ModuleAccess::where('user_id', $user->id)->delete();
                    if (count($moduleAccess) > 0){
                        ModuleAccess::insert($moduleAccess);
                    }

                }

                $message = ($id <= 0) ? 'New administrator is added.' : 'Administrator details is updated';
                Session::flash('success', $message);
//                DB::commit();
            } catch (\Exception $e){
//                DB::rollback();
                $error = true;
                $message = $this->formatException($e);
            }

        } else {
            $error = true;
        }

        return ($error) ? redirect('admin/administrators/form/'.$id)
            ->with('danger', $message)
            ->withErrors($validation->errors())
            ->withInput() : redirect('admin/administrators');

    }

    function getDelete($id){
        if ($id == $this->mainAdminID){
            return redirect('admin/administrators');
        }
        $user = User::find($id);
        Details::where('id', $user->user_details_id)->delete();
        $user->delete();
        Session::flash('success', 'Selected admin was deleted.');
        return redirect('admin/administrators');
    }
}