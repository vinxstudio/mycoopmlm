<?php
namespace App\Http\Modules\Admin\NewsUpdate\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\NewsUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Validator;

class NewsUpdateController extends AdminAbstract{

    protected $viewpath = 'Admin.NewsUpdate.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
    	// $data = Announcement::where('user_id', $this->theUser['id'])->get();
    	$data = DB::table('news_update')
    		->where([
    				'user_id' => $this->theUser['id'],
    				'delete' => 0
    			])
            ->orderBy('id', 'desc')
    		->get();
    	return view( $this->viewpath . 'index' )
    		->with([
    			"news_update" => $data
    		]);
    }

    function postIndex(Request $request){
    	$input = new NewsUpdate;
    	$user_id = $this->theUser['id'];

    	$input->user_id = $user_id;
    	$input->news_title = $request->input("title");
    	$input->news_details = $request->input("details");
        $input->news_from = $request->input("from");
    	$input->display_date = $request->input("date");
    	$input->status = 1;
    	
    	if($input->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postDelete($id){
		$news = NewsUpdate::find($id);

    	$news->id = $news->id;
    	$news->delete = 1;

    	if($news->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postEdit($id){
    	$data = DB::table('news_update')
    		->where([
    				'id' => $id,
    			])
    		->get();
    	echo json_encode($data);
    }

    function postUpdate(Request $request, $id){
    	$input = NewsUpdate::find($id);
    	$input->news_title = $request->input("title");
    	$input->news_details = $request->input("details");
        $input->news_from = $request->input("from");
    	$input->display_date = $request->input("date");

    	if($input->save()){
    		echo json_encode("success");
    	}else{
    		echo json_encode("failed");
    	}
    }

    function postStatus($id){
    	$announcement = NewsUpdate::find($id);

    	$announcement->status = $announcement['status'] == 0 ? 1 : 0;
    	$announcement->save();
    }
}
