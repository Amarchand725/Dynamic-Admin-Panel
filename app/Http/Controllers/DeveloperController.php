<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\BusinessSetting;

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
    public function addBusinessSetting(){
        $settings = config('system.settings');
        $businessSetting = new BusinessSetting();
        foreach ($settings as $category => $group) {
            if (is_array($group)) {
                foreach ($group as $key => $item) {
                    $value = is_array($item) ? $item['value'] ?? null : $item;
                    $inputType = is_array($item) ? $item['input_type'] ?? 'text' : 'text';

                    $businessSetting->firstOrCreate(
                        ['key' => $key],
                        [
                            'category' => $category,
                            'value' => $value,
                            'input_type' => $inputType,
                        ]
                    );
                }
            } else {
                $businessSetting->firstOrCreate(
                    ['key' => $category],
                    [
                        'category' => null,
                        'value' => $group,
                        'input_type' => 'text',
                    ]
                );
            }
        }

        return $businessSetting->get();
    }
}