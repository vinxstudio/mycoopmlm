<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/22/16
 * Time: 2:38 PM
 */

if (!function_exists('isForSetup')){

    function isForSetup(){
        $systemHelper = new \App\Helpers\SystemHelperClass();
        return ($systemHelper->company->first_time == 'true') ? true : false;
    }

}

if (!function_exists('SystemSettings')){

    function SystemSettings($fieldName){
        $systemHelper = new \App\Helpers\SystemHelperClass();
        return $systemHelper->company->$fieldName;
    }

}

if (!function_exists('makeBatchId')){

    function makeBatchId(){
        $batch = \App\Models\ActivationCodeBatches::orderBy('id', 'desc')->get();
        $company = \App\Models\Company::find(1);
        $prefix = 1;
        if (!$batch->isEmpty()){
            $prefix = $batch->first()->id;
        }
        $batchPrefix = 'batch'.$company->activation_code_prefix;

        return strtoupper($batchPrefix.$prefix);
    }

}

if (!function_exists('shortEncrypt')){
    function shortEncrypt($in, $to_num = false, $pad_up = false, $pass_key = null){
        $out   =   '';
        $index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base  = strlen($index);

        if ($pass_key !== null) {
            // Although this function's purpose is to just make the
            // ID short - and not so much secure,
            // with this patch by Simon Franz (http://blog.snaky.org/)
            // you can optionally supply a password to make it harder
            // to calculate the corresponding numeric ID

            for ($n = 0; $n < strlen($index); $n++) {
                $i[] = substr($index, $n, 1);
            }

            $pass_hash = hash('sha256',$pass_key);
            $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

            for ($n = 0; $n < strlen($index); $n++) {
                $p[] =  substr($pass_hash, $n, 1);
            }

            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }

        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $len = strlen($in) - 1;

            for ($t = $len; $t >= 0; $t--) {
                $bcp = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }
        } else {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up)) {
                $pad_up--;

                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a   = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in  = $in - ($a * $bcp);
            }
        }

        return $out;
    }
}

if (!function_exists('array_combine2')){
    function array_combine2($arr1, $arr2) {
        $count = min(count($arr1), count($arr2));
        return array_combine(array_slice($arr1, 0, $count), array_slice($arr2, 0, $count));
    }

}

if (!function_exists('custom_substring')){
    function custom_substring($string, $max = 10) {
        $suffix = (strlen($string) > $max) ? '...' : '';
        return substr($string, 0, $max - 3) . $suffix;
    }

}

if (!function_exists('LoadJS')){
    function LoadJS($script) {
        return sprintf('<script type="text/javascript" src="%s"></script>', url($script));
    }
}

if (!function_exists('LoadCSS')){
    function LoadCSS($css) {
        return sprintf('<link rel="stylesheet" type="text/css" href="%s"/>', url($css));
    }
}

if (!function_exists('startsWith')) {

    function startsWith($haystack, $needle){
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

}

if (!function_exists('endsWith')) {

    function endsWith($haystack, $needle){
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('LoadPlugin')){

    function LoadPlugin($pluginKey, $whatToLoad = 'js'){

        $cssToLoad = [];
        $jsToLoad = [];

        if (isset(config('asset')[$pluginKey])) {
            $plugin = config('asset')[$pluginKey];

            $beginPath = $plugin['path'];
            if (!endsWith('/', $beginPath)) {
                $beginPath .= '/';
            }

            if (isset($plugin['css'])) {
                foreach ($plugin['css'] as $cssPlugin) {
                    $pluginPath = $cssPlugin;
                    if (starts_with('/', $pluginPath)) {
                        $pluginPath = substr($cssPlugin, 1);
                    }
                    array_push($cssToLoad, sprintf('%s%s', $beginPath, $pluginPath));
                }
            }

            if (isset($plugin['js'])) {
                foreach ($plugin['js'] as $jsPlugin) {
                    $pluginPath = $jsPlugin;
                    if (starts_with('/', $pluginPath)) {
                        $pluginPath = substr($jsPlugin, 1);
                    }
                    array_push($jsToLoad, sprintf('%s%s', $beginPath, $pluginPath));
                }
            }

            if (isset($plugin['outsource_js'])) {
                foreach ($plugin['outsource_js'] as $outsourceJs) {
                    array_push($this->outsourceJs, $outsourceJs);
                }
            }

            if (isset($plugin['outsource_css'])) {
                foreach ($plugin['outsource_css'] as $outsourceCss) {
                    array_push($this->outsourceCss, $outsourceCss);
                }
            }
        }

        $loadedJs = '';
        $loadedCss = '';

        foreach ($jsToLoad as $js){
            $loadedJs .= LoadJS($js);
        }

        foreach ($cssToLoad as $css){
            $loadedCss .= LoadCSS($css);
        }

        return ($whatToLoad == 'js') ? $loadedJs : $loadedCss;

    }

}

if (!function_exists('getCompanyObject')) {
    function getCompanyObject(){

        return \App\Models\Company::find(1);

    }
}

if (!function_exists('gatewayOption')) {
    function gatewayOption($optionName){

        $option = \App\Models\GatewayOptions::all();

        $value = null;
        foreach ($option as $opt){
            if ($opt->option_name == $optionName){
                $value = $opt->option_value;
            }
        }

        return $value;

    }
}

if (!function_exists('codePurchaseAmount')){
    function codePurchaseAmount(){
//       $company = \App\Models\Company::find(1);
//       $charge = (int)config('system.repeat_sales_charge');
        $additionalCharge = 0;//($charge > 0) ? ($charge/100)*$company->entry_fee : 0;

        // *edit by keen - 1/20/2018
        $user = \Illuminate\Support\Facades\Auth::id();
        $user_type = \App\Models\User::find($user);
        $member_type = $user_type->member_type_id;
        $membership = \App\Models\Membership::find($member_type);
        // end

        return $membership->entry_fee + $additionalCharge;
    }
}

if (!function_exists('readConfig')){
    function readConfig($filePath){

        $values = [];

        if (file_exists($filePath)){
            $values = include($filePath);
        }

        return $values;
    }
}

if (!function_exists('updateConfig')){
    function updateConfig($filePath, $value){
        file_put_contents($filePath, sprintf('<?php return %s;', arrayExporter($value)));
    }
}

function arrayExporter($data) {

    $filtered_array = filterMultiDimensionalArray($data, [], function($value) {
        return stripslashes($value);
    });

    return var_export($filtered_array, true);
}

function filterMultiDimensionalArray($array, $keys = [], $callback) {
    if (count($keys)) {
        $inside_arr = $array;
        $inside_arr_str = "";

        foreach ($keys as $k) {
            $inside_arr_str .= "['" . $k . "']";
            $inside_arr = $inside_arr[$k];
        }

        foreach ($inside_arr as $arr => $value) {
            if (is_array($value)) {
                array_push($keys, $arr);

                $array = filterMultiDimensionalArray($array, $keys, $callback);
                array_pop($keys);
            } else {
                $data_keys = $keys;
                array_push($data_keys, $arr);

                eval('$array' . $inside_arr_str . '["' . $arr . '"] ="' . $callback($value, $data_keys) . '";');
            }
        }
        return $array;
    } else {
        foreach ($array as $arr => $value) {
            if (is_array($value)) {
                $array = filterMultiDimensionalArray($array, array($arr), $callback);
            } else {
                $data_keys = [$arr];
                $array[$arr] = $callback($value, $data_keys);
            }
        }
    }

    return $array;
}

function isEmailRequired(){
    return (config('system.require_email') == TRUE_STATUS) ? true : false;
}

function hasAccess($moduleName){
    $user = \Illuminate\Support\Facades\Auth::user();
    return (in_array($moduleName, $user->modulesArray) or $user->role == ADMIN_ROLE and $user->default_member == TRUE) ? true : false;
}

function getRealCompanyIncome(){
    //$company = \App\Models\Company::find(1);
    //$entry = $company->entry_fee;

    // *edit by keen - 1/20/2018
    $user = \Illuminate\Support\Facades\Auth::id();
    $user_type = \App\Models\User::find($user);
    $member_type = $user_type->member_type_id;
    $membership = \App\Models\Membership::find($member_type);
    $entry = $membership->entry_fee;
    // end

    $referral = $company->referral_income;
    $moneyPot = $company->money_pot;

    $totalGiveaways = $entry + $referral;
    $totalGiveaways += $moneyPot;

    return $entry - $totalGiveaways;
}