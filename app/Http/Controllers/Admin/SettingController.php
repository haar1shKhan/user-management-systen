<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {  
        $data = [
            'page_title' => 'Settings',
        ];
        
        return view('admin.settings.index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        unset($data['_method']);
        unset($data["_token"]);

        foreach ($data as $key => $value){

            $setting = Setting::where('key','=', $key)->where('code','=', "settings")->first();

            if ($key == "site_icon") {
                $fileName = 'site_icon.' . $request->site_icon->extension();
                $request->file('site_icon')->storeAs('public/site_images', $fileName);
        
                // Update profile data with the new image
                $setting->value = "storage/site_images/".$fileName;
                $setting->save();
                continue; 
            }

            if ($key == "site_logo") {
                $fileName = 'site_logo.' . $request->site_logo->extension();
                $request->file('site_logo')->storeAs('public/site_images', $fileName);
        
                // Update profile data with the new image
                $setting->value = 'storage/site_images/'. $fileName;
                $setting->save();
                continue;
            }

            if ($key == "mail_logo") {
                $fileName = 'mail_logo.' . $request->mail_logo->extension();
                $request->file('mail_logo')->storeAs('public/site_images', $fileName);
        
                // Update profile data with the new image
                $setting->value = "storage/site_images/".$fileName;
                $setting->save();
                continue;
            }

            $setting->value = $value;
            $setting->save();
        }

        return redirect()->route('admin.settings');
    }
}
