<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 4/16/17
 * Time: 3:25 PM
 */

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