<?php

namespace App\Http\Controllers;

use App\Models\S3Object;
use Illuminate\Http\Request;

class S3ObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('s3Objects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = [];
        $startYear = (date('Y') - 5);
        $endYear = (date('Y') + 5);
        for ($year=$startYear; $year <= $endYear; $year++) { 
            $years[] = $year;
        }

        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $data['years'] = $years;
        $data['months'] = $months;

        return view('s3Objects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\S3Object  $s3Object
     * @return \Illuminate\Http\Response
     */
    public function show(S3Object $s3Object)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\S3Object  $s3Object
     * @return \Illuminate\Http\Response
     */
    public function edit(S3Object $s3Object)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\S3Object  $s3Object
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, S3Object $s3Object)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\S3Object  $s3Object
     * @return \Illuminate\Http\Response
     */
    public function destroy(S3Object $s3Object)
    {
        //
    }
}
