<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index(Setting $setting)
    {
            return view('settings.index', ['settings' => $setting->first()]);
    }


    public function update(Request $request, $id)
    {
        $settings = Setting::find($id);

        // company detail
       $settings->admin_commission  = $request->admin_commission;
       $settings->google_map_key = $request->google_map_key;
        $settings->update();

        return redirect()->route('settings.index')->withStatus(__('Settings successfully updated!'));
    }
}
