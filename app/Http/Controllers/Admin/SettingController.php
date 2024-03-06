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
    public $base_url = '/admin/settings';

    public function index()
    {  
        $page_title = 'Settings';

        $data = array(
            'page_title' => $page_title,
            'url' =>  $this->base_url,
        );
        
        return view('admin.settings.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validation = $request->validate([
        //     'store_name' => 'required',
        //     'store_owner' => 'required',
        //     'store_address' => 'required',
        //     'store_email' => 'required|email',
        //     'store_phone' => 'required',
        //     'store_telephone' => 'required',
        //     'store_Latitude' => 'required',
        //     'store_longitude' => 'required',
        // ]);

        $data = $request->all();
        unset($data['_method']);
        unset($data["_token"]);
        foreach ($data as $key => $value){
            $setting = Setting::where('key','=', $key)->where('code','=', "settings")->first();
            // echo '<pre>';
            // echo  $key;
            // echo "<br>";
            // echo  $setting;
            // echo "<br>";
            // echo  $value;
            // echo "<br>";
            // echo "<br>";
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
            if ($key == "site_email") {
                $fileName = 'site_email.' . $request->site_email->extension();
                $request->file('site_email')->storeAs('public/site_images', $fileName);
        
                // Update profile data with the new image
                $setting->value = "storage/site_images/".$fileName;
                $setting->save();
                continue;
            }

            $setting->value = $value;
            $setting->save();
        }
        // die;
        return redirect($this->base_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
