<?php
namespace App\Http\Modules\Admin\Announcement\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Validator;

class AnnouncementAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Announcement.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
    	// $data = Announcement::where('user_id', $this->theUser['id'])->get();
    	$data = DB::table('announcement')
    		->where([
    				'user_id' => $this->theUser['id'],
    				'delete' => 0
    			])
            ->orderBy('id', 'desc')
    		->get();
    	return view( $this->viewpath . 'index' )
    		->with([
    			"announcement" => $data
    		]);
    }

    function postIndex(Request $request){
    	$input = new Announcement;
    	$user_id = $this->theUser['id'];

    	$input->user_id = $user_id;
    	$input->announcement_title = $request->input("title");
    	$input->announcement_details = $request->input("details");
        $input->announcement_from = $request->input("from");
    	$input->display_date = $request->input("date");
    	$input->status = 1;
    	
    	if($input->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postDelete($id){
		$announcement = Announcement::find($id);

    	$announcement->id = $announcement->id;
    	$announcement->delete = 1;

    	if($announcement->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postEdit($id){
    	$data = DB::table('announcement')
    		->where([
    				'id' => $id,
    			])
    		->get();
    	echo json_encode($data);
    }

    function postUpdate(Request $request, $id){
    	$input = Announcement::find($id);
    	$input->announcement_title = $request->input("title");
    	$input->announcement_details = $request->input("details");
        $input->announcement_from = $request->input("from");
    	$input->display_date = $request->input("date");

    	if($input->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postStatus($id){
    	$announcement = Announcement::find($id);

    	$announcement->status = $announcement['status'] == 0 ? 1 : 0;
    	$announcement->save();
    }
}
