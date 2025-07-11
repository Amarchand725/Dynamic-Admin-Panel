<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;

class SettingController extends Controller
{
    public function create()
    {
        $this->authorize('settings-create');
        $settings = BusinessSetting::first();
        if(empty($settings)){
            $title = 'Setting';
            return view('admin.settings.create', compact('title'));
        }else{
            return redirect()->route('settings.edit', $settings->id);
        }
    }

    public function edit($id)
    {
        $this->authorize('settings-edit');
        $title = 'Setting Details';
        $model = BusinessSetting::get();
        if(empty($model)){
            return redirect()->route('settings.create');
        }
        $countryName = getSetting('country', null);
        $country = Country::where('name', 'like', '%' . $countryName.'%')->first();
        
        $states = [];
        if(!empty($country)){
            $states = State::where('country_id', $country->id)->get();
        }
        $stateName = getSetting('state', null);
        $state = State::where('name', 'like', '%' .$stateName.'%')->first();
        
        $cities = [];
        if(!empty($state)){
            $cities = City::where('state_id', $state->id)->get();
        }
        
        return view('admin.settings.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'settings.name' => 'required|string|max:255',
            'settings.phone_number' => 'required|string|max:255',
            'settings.support_email' => 'required|string|max:255',
            'settings.address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try{
            $settings = $request->settings;
            foreach($settings as $key=>$setting){
                $settingModel = BusinessSetting::where('key', $key)->first();

                // Check if this key is a file input
                if ($request->hasFile("settings.$key")) {
                    // Delete old file if it exists
                    if ($settingModel && !empty($settingModel->value)) {
                        $oldImagePath = storage_path('app/public/' . $settingModel->value);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $file = $request->file("settings.$key");

                    // Optionally, you can generate a custom filename
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Store the file (adjust path as needed)
                    $filePath = $file->storeAs('uploads/company', $filename, 'public');

                    // Save the file path as the value
                    $value = $filePath;
                }else{
                    $value = $setting;
                }
                
                if(!empty($settingModel)){
                    $settingModel->value = $value;
                    $settingModel->save();
                }else{
                    BusinessSetting::create([
                        'key' => $key,
                        'value' => $value,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('message', 'Setting details updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
