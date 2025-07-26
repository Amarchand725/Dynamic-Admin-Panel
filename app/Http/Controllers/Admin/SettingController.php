<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index(){
        $this->authorize('settings-list');
        $title = 'All Settings';
        $business_settings = BusinessSetting::select(['id', 'category', 'key', 'value', 'input_type'])->get()->groupBy('category');
        return view('admin.settings.index', get_defined_vars());
    }

    public function edit($category){
        $business_settings = BusinessSetting::where('category', $category)
                    ->select(['id', 'category', 'key', 'value', 'input_type'])
                    ->get();
        return view('admin.settings.edit_content', get_defined_vars());
    }
    
    public function update(Request $request, $id){
        $category = $request->input('category');
        $inputSettings = $request->input('settings', []);
        $fileSettings = $request->file('settings', []);

        $allKeys = array_unique(array_merge(array_keys($inputSettings), array_keys($fileSettings)));

        try {
            foreach ($allKeys as $key) {
                $setting = BusinessSetting::where('category', $category)->where('key', $key)->first();

                $value = $inputSettings[$key] ?? null;

                if ($request->hasFile("settings.$key")) {
                    $file = $request->file("settings.$key");
                    $value = $file->store('uploads/settings', 'public');
                }

                if ($setting) {
                    $setting->value = $value;
                }
            }

            $setting->save();

            return response()->json(['success' => true, 'message' => ucfirst($category).' settings updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}