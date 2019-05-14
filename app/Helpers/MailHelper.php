<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 5/27/17
 * Time: 1:38 PM
 */

namespace App\Helpers;

use App\Models\EmailTemplates;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class MailHelper{

    protected $keywords = [
        USER_FIRST_NAME_KEY,
        USER_LAST_NAME_KEY,
        USER_FULL_NAME_KEY,
        USER_EMAIL_KEY,
        USER_ACCOUNT_ID_KEY,
        USER_LOGIN_USERNAME_KEY,
        USER_WITHDRAWAL_STATUS_KEY,
    ];

    protected $acceptableEmailTypes = [
        REGISTRATION_KEY,
        LOGIN_KEY,
        WITHDRAWAL_KEY
    ];

    protected $userObject;
    protected $mailView = 'emails.defaultMail';
    protected $preview = false;
    protected $verificationCode = '';
    protected $withdrawalObject = null;

    function getKeywordsWithDescription(){

        $result = [];

        $result[USER_FIRST_NAME_KEY] = Lang::get('mailing.member_first_name');
        $result[USER_LAST_NAME_KEY] = Lang::get('mailing.member_last_name');
        $result[USER_FULL_NAME_KEY] = Lang::get('mailing.member_full_name');
        $result[USER_EMAIL_KEY] = Lang::get('mailing.member_email');
        $result[USER_ACCOUNT_ID_KEY] = Lang::get('mailing.member_account_id');
        $result[USER_LOGIN_USERNAME_KEY] = Lang::get('mailing.member_username');
        $result[USER_WITHDRAWAL_STATUS_KEY] = Lang::get('withdrawal.request_status');

        return $result;
    }

    function getTemplates(){
        $mail = EmailTemplates::all();

        $result = [];

        foreach ($mail as $template){
            $result[$template->type] = $template->content;
        }

        return $result;
    }

    function setUserObject($user){
        $this->userObject = $user;
        return $this;
    }

    function setPreview($bool){
        $this->preview = $bool;
        return $this;
    }

    function setVerificationCode($code){
        $this->verificationCode = $code;
        return $this;
    }

    function setWithdrawalObject($withdraw){
        $this->withdrawalObject = $withdraw;
        return $this;
    }

    function sendMail($type){

        $user = $this->userObject;
        $sendmail = false;
        if ($user != null and isset($user->id) and $user->details->email != null) {
            $sendmail = true;
        }

        if (!isEmailRequired()){
            $sendmail = false;
        }

        if ($sendmail){
            $templates = $this->getTemplates();
            if (in_array($type, $this->acceptableEmailTypes) and isset($templates[$type])) {

                $data['mailContent'] = $this->replaceKeys($templates[$type]);
                $email = $user->details->email;
                $company = getCompanyObject();
                $subjects = $this->getRequestTypeSubjects();

                if ($this->verificationCode != null){
                    $data['verificationCode'] = $this->verificationCode;
                }

                if ($this->withdrawalObject != null){
                    $data['withdrawal'] = $this->withdrawalObject;
                }

                if (!$this->preview) {
                    Mail::send($this->mailView, $data, function ($message) use ($email, $company, $subjects, $type) {
                        $message->from(config('system.default_email'), $subjects[$type]);
                        $message->to($email)->subject($subjects[$type]);
                    });
                } else {
                    return view($this->mailView)->with($data);
                }
            }
        }

    }

    private function getRequestTypeSubjects(){
        $subjects = [];

        foreach ($this->acceptableEmailTypes as $mailType){
            $subjects[$mailType] = Lang::get(sprintf('mailing.%s_mail_subject', $mailType));
        }

        return $subjects;
    }

    private function replaceKeys($content){
        if (isset($this->userObject->id)){

            $result = [];
            $result[USER_FIRST_NAME_KEY] = $this->userObject->details->first_name;
            $result[USER_LAST_NAME_KEY] = $this->userObject->details->last_name;
            $result[USER_FULL_NAME_KEY] = $this->userObject->details->fullName;
            $result[USER_EMAIL_KEY] = $this->userObject->details->email;
            $result[USER_ACCOUNT_ID_KEY] = isset($this->userObject->account->code->account_id) ? $this->userObject->account->code->account_id : 0;
            $result[USER_LOGIN_USERNAME_KEY] = $this->userObject->username;
            $result[USER_WITHDRAWAL_STATUS_KEY] = (isset($this->withdrawalObject->id)) ? ucwords($this->withdrawalObject->status) : null;

            foreach ($this->keywords as $keyword){
                if (isset($result[$keyword])) {
                    $theKeyword = sprintf('%s%s%s', MAILING_PREFIX, $keyword, MAILING_SUFFIX);
                    $content = str_replace($theKeyword, $result[$keyword], $content);
                }
            }

        }

        return $content;
    }

}