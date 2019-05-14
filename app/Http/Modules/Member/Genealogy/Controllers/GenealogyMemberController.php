<?php
namespace App\Http\Modules\Member\Genealogy\Controllers;

use App\Http\AbstractHandlers\MemberAbstract;

class GenealogyMemberController extends MemberAbstract{

    protected $viewpath = 'Member.Genealogy.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($level = null){

    }

}