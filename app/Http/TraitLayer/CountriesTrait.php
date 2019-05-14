<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/13/17
 * Time: 9:54 PM
 */

namespace App\Http\TraitLayer;

use App\Models\Countries;

trait CountriesTrait{

    function getCountriesDropdown(){
        $countries = Countries::all();

        $dropdown = [];

        foreach ($countries as $country){
            $dropdown[$country->id] = $country->name;
        }

        return $dropdown;
    }

}