<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/21/16
 * Time: 9:52 PM
 */
namespace App\Models;

use App\Http\TraitLayer\GlobalSettingsTrait;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractLayer extends Model{

    use GlobalSettingsTrait;

    protected $namespace = 'App\Models';

}