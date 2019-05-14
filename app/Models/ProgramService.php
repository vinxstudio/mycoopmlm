<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramService extends Model {
	protected $table = 'program_services';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'image_banner_path',
        'image_icon_path',
        'publish_date',
        'publish_status',
        'order',
        'type',
        'cost'
    ];

    /**
     * @var array
     */
    protected $dates = ['publish_date', 'deleted_at', 'created_at'];

    /**
     * @var constants
     */
    const TYPE_SERVICES  = '1';
    const TYPE_PROGRAMS  = '2';
    const TYPES = [
        self::TYPE_SERVICES  => 'Services',
        self::TYPE_PROGRAMS  => 'Programs'
    ];

    const TYPE_ETOURS          = '12';
    const TYPE_SAVINGS         = '6';
    const TYPE_DAMAYAN         = '7';
    const TYPE_FINANCING       = '2';
    const TYPE_FRANCHISE       = '6';
    const TYPE_HOSPITALIZATION = '4';
    const TYPE_EHOTEL          = '8';
}
