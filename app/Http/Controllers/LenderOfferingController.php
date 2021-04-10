<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LenderOffering;
use Illuminate\Support\Facades\DB;

class LenderOfferingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lenderOfferings($orgId)
    {
        
        $payment_periods = DB::table('lender_offerings')
        ->where('lender_organization_id',$orgId)
        ->distinct()
        ->orderBy('Payment_period','ASC')
        ->get('Payment_period');

        $percentages = DB::table('lender_offerings')
        ->where('lender_organization_id',$orgId)
        ->distinct()
        ->orderBy('percentage','ASC')
        ->get('percentage');

        return response()->json([
        'payment_periods' => $payment_periods,
        'percentages' => $percentages,
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LenderOffering  $lenderOffering
     * @return \Illuminate\Http\Response
     */
    public function show(LenderOffering $lenderOffering)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LenderOffering  $lenderOffering
     * @return \Illuminate\Http\Response
     */
    public function edit(LenderOffering $lenderOffering)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LenderOffering  $lenderOffering
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LenderOffering $lenderOffering)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LenderOffering  $lenderOffering
     * @return \Illuminate\Http\Response
     */
    public function destroy(LenderOffering $lenderOffering)
    {
        //
    }
}
