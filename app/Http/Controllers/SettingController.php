<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle ="Settings";
        $settings = Setting::all();
        return view('dashboard.settings.index',compact('settings','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle ="Add Settings";
        return view ('dashboard.settings.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'key'=> 'required|string|unique:settings,key',
            'value'=>'required|string',
            'status'=>'required:in:1,0'
        ]);
        $setting = Setting::create([
                'key' => $request->key,
                'value' => $request->value,
                'status'=>$request->status
            ]);
        if($setting){
            return redirect()->route('dashboard.settings.index')->with('success','Setting added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        $pageTitle ="Update Settings";
        return view('dashboard.settings.edit', compact('setting','pageTitle'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting) {
        $request->validate([
            'key' => 'required|string|unique:settings,key,' . $setting->id,
            'value' => 'required|string',
            'status' => 'required|in:1,0',
        ]);

        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.settings.index')->with('success','Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
    
        return redirect()->route('dashboard.settings.index')->with('success','Setting deleted successfully.');
    }
    
}