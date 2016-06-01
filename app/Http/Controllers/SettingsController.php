<?php

namespace App\Http\Controllers;

use App\Events\SettingsChanged;
use App\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function create()
    {
        return view('settings.create');
    }
    public function edit($settingId)
    {
        $setting = Setting::findOrFail($settingId);
        event(new SettingsChanged());
        return view('settings.edit', compact('setting'));
    }
    public function update(Request $request, $settingId)
    {
        $rules = [
            'label'=>'required',
            'value'=>'required',
            'code'=>'required|alpha_dash|unique:settings,code,'.$settingId,
            'type'=>'required|in:text,file',
        ];
        $this->validate($request, $rules);

        $permission = Setting::findOrFail($settingId);

        $permission->update($request->all());

        event(new SettingsChanged());

        return redirect('/settings')->withMessage('Setting Update Successfully!');
    }
    public function store(Request $request)
    {
        $rules = [
            'label'=>'required',
            'value'=>'required',
            'code'=>'required|alpha_dash|unique:settings,code',
            'type'=>'required|in:text,file',
        ];
        $this->validate($request, $rules);

        Setting::create($request->all());

        event(new SettingsChanged());

        return redirect('/settings')->withMessage('Setting Created Successfully!');

    }
    public function delete($settingId)
    {
        $setting = Setting::findOrFail($settingId);

        $setting->delete();

        event(new SettingsChanged());

        return redirect('/settings')->withMessage('Setting Delete Successfully!');
    }
}
