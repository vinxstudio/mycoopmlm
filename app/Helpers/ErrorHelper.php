<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 4/21/16
 * Time: 4:20 PM
 */

if (!function_exists('validationError')){
    function validationError($errors, $fieldName){
        $html = '';
        if ($errors->first($fieldName)){
            $html .= '<div class="row col-md-12 col-xs-12"><label class="error" style="display: inline-block;">';
            $html .= $errors->first($fieldName);
            $html .= '</label></div>';
        }

        return $html;
    }
}

if (!function_exists('BootstrapAlert')){

    function BootstrapAlert($type = null){

        $defaults = ['info','success','warning','danger'];

        $html = '';

        foreach ($defaults as $key => $value) {

            $the_value = ($type!=null) ? $type : $value;
            $button = '<button type="button" class="close" data-dismiss="alert"></button>';
            if ( session($the_value) ) {
                $html = "<div onload=\"$(this).trigger_alert_animation()\" class=\"alert alert-".$the_value."\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>".session($the_value)."</div>";
                break;
            }
        }

        return $html;
    }
}