<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 5/27/17
 * Time: 12:34 PM
 */

namespace App\Http\Modules\Admin\Mailing\Controllers;

use App\Helpers\MailHelper;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class MailingAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Mailing.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        $mail = new MailHelper();

        return view( $this->viewpath . 'index' )
            ->with([
                'keywords'=>$mail->getKeywordsWithDescription(),
                'emailTemplates'=>$mail->getTemplates()
            ]);
    }

    function postIndex(Request $request){

        $messageType = 'success';
        $message = null;
        try {
            $loop = [
                'registration',
                'verification',
                'withdrawal',
            ];

            $save = [];

            foreach ($loop as $fieldname) {

                $save[] = [
                    'type' => $fieldname,
                    'content' => $request->{$fieldname},
                    'created_at' => date($this->createdAtFormat)
                ];

            }

            EmailTemplates::truncate();
            if (count($save) > 0) {
                EmailTemplates::insert($save);
            }

            $config = readConfig($this->systemConfig);
            $config['require_email'] = ($request->require_email == 'on') ? TRUE_STATUS : FALSE_STATUS;
            updateConfig($this->systemConfig, $config);

        } catch (\Exception $e){
            $messageType = 'danger';
            $message = $this->formatException($e);
        }

        return back()->with($messageType, ($messageType == 'danger') ? $message : Lang::get('mailing.saved'));

    }

}