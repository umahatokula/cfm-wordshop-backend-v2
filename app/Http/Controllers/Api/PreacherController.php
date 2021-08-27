<?php

namespace App\Http\Controllers\Api;

use App\Models\Preacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PreacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['preachers'] = Preacher::all();

        return view('preachers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('preachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Preacher Name is required',
    	];

        $this->validate($request, $rules, $messages);

        $preacher = new Preacher;
        $preacher->name = $request->name;
        $preacher->save();

        return redirect('preachers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preacher  $preacher
     * @return \Illuminate\Http\Response
     */
    public function show(Preacher $preacher)
    {
        $data['preacher'] = Preacher::find($preacher->id);

        return view('preachers.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preacher  $preacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Preacher $preacher)
    {
        $data['preacher'] = Preacher::find($preacher->id);

        return view('preachers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preacher  $preacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preacher $preacher)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Preacher Name is required',
    	];

        $this->validate($request, $rules, $messages);

        $preacher = Preacher::find($preacher->id);
        $preacher->name = $request->name;
        $preacher->save();

        return redirect('preachers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preacher  $preacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preacher $preacher)
    {
        Preacher::findOrFail($preacher->id)->delete();

        return redirect('preachers');
    }
}
