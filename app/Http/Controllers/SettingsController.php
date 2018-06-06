<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use \App\Http\Requests;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = \App\Setting::all()->first();
        if($settings==null) $settings = [];
        return view('settings')->with(['settings'=>$settings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SettingsRequest $request)
    {
        $input = \Input::all();
        if(strlen($input['notification_number'])==10)
            $input['notification_number']='+254'.substr($input['notification_number'], 1);

        $new = \App\Setting::create($input);
        return response()->json($new->toArray());
    }

    public function store_quick(Requests\QuickSettingsRequest $request){
        $new = \App\Setting::create(\Input::all());
        return response()->json($new->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SettingsRequest $request, $id)
    {
        $settings = \App\Setting::find($id);
        $input = \Input::all();
        if(strlen($input['notification_number'])==10)
            $input['notification_number']='+254'.substr($input['notification_number'], 1);

        $settings->update($input);
        $settings->save;

        return response()->json($settings);
    }

    public function update_quick(Requests\QuickSettingsRequest $request, $id){
        $settings = \App\Setting::find($id);

        $settings->update(\Input::all());
        $settings->save;

        return response()->json($settings);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
