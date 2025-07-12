<?php

use App\Models\City;
use App\Models\State;
use App\Models\Country;

if (!function_exists('countries')) {
    function countries()
    {
        return Country::get();
    }
}

if (!function_exists('states')) {
    function states($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return $states ? $states->toArray() : [];
    }
}

if (!function_exists('cities')) {   
    function cities($stateId)
    {
        $cities = City::where('country_id', $stateId)->get();
        return $cities ? $cities->toArray() : [];
    }
}

if (!function_exists('getCountryStateCityId')) {
    function getCountryStateCityId($type, $name)
    {
        if($type=='Country'){
            $country = Country::where('name', $name)->first();

            if ($country) {
                return $country->id;
            }

            return null; 
        }elseif($type=='State'){
            $state = State::where('name', $name)->first();

            if ($state) {
                return $state->id;
            }

            return null; 
        }elseif($type=='City'){
            $city = City::where('name', $name)->first();

            if ($city) {
                return $city->id;
            }

            return null; 
        }else{
            return null;
        }
    }
}