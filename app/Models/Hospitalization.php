<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospitalization extends Model {
	protected $table = 'hospitalization';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        "requester_id",
        "application_date",
        "mccrc_control_no",
        "cooperative_name",
        "cooperative_address",
        "last_name",
        "first_name",
        "middle_name",
        "present_address",
        "present_address_zip_code",
        "provincial_address",
        "provincial_address_zip_code",
        "civil_status",
        "sex",
        "contact_number",
        "email_address",
        "facebook_account",
        "occupation",
        "employer_name",
        "yrs_in_company",
        "date_hired",
        "employer_address",
        "family_immediate_last_name_1",
        "family_immediate_first_name_1",
        "family_immediate_middle_name_1",
        "family_immediate_relationship_1",
        "family_immediate_birthdate_1",
        "family_immediate_gender_1",
        "family_immediate_civil_status_1",
        "family_immediate_last_name_2",
        "family_immediate_first_name_2",
        "family_immediate_middle_name_2",
        "family_immediate_relationship_2",
        "family_immediate_birthdate_2",
        "family_immediate_gender_2",
        "family_immediate_civil_status_2",
        "family_immediate_last_name_3",
        "family_immediate_first_name_3",
        "family_immediate_middle_name_3",
        "family_immediate_relationship_3",
        "family_immediate_birthdate_3",
        "family_immediate_gender_3",
        "family_immediate_civil_status_3",
        "type_string"
    ];

    /**
     * @var constants
     */
    const TYPE_NEW     = '1';
    const TYPE_RENEWAL = '2';
    const TYPES = [
        self::TYPE_NEW     => '1',
        self::TYPE_RENEWAL => '2'
    ];
    const COSTS = [
        self::TYPE_NEW     => 'New',
        self::TYPE_RENEWAL => 'Renewal'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }

    public function getTypeStringAttribute()
    {
        return TYPES[$this->type];
    }
}
