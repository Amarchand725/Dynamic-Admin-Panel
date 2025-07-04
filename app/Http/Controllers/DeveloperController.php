<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;

class DeveloperController extends Controller
{
    public function getCountries(){
        return Country::select(['name', 'code', 'iso2', 'iso3', 'phone_code', 'currency', 'currency_name', 'currency_symbol'])->get();
    }

    public function getStates(){
        return State::select(['country_id', 'name', 'iso2'])->get();
    }
    public function getCities(){
        return City::select(['state_id', 'name'])->get();
    }
}