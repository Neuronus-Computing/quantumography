<?php

namespace App\Http\Controllers;

use App\Models\VangographyPlan;
use Illuminate\Http\Request;

class VangographyPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Vangonography Plans';
        $plans = VangographyPlan::all();
        return view('dashboard.vangography.plans.index', compact('plans','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Vangonography Plan create';
        return view('dashboard.vangography.plans.create',compact('pageTitle'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'plan_name' => 'required|unique:vangography_plans,plan_name',
            'size' => 'numeric|required|min:0.5|unique:vangography_plans,size',
            'price' => 'required',
        ]);

        VangographyPlan::create($data);

        return redirect()->route('dashboard.vangography.plan.index')->with('success', 'Plan created successfully.');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VangographyPlan  $vangographyPlan
     * @return \Illuminate\Http\Response
     */
    public function show(VangographyPlan $vangographyPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VangographyPlan  $vangographyPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(VangographyPlan $vangographyPlan)
    {
        $pageTitle = 'Vangonography Plan Edit';
        return view('dashboard.vangography.plans.edit', compact('vangographyPlan','pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VangographyPlan  $vangographyPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VangographyPlan $vangographyPlan)
    {
       $data=$request->validate([
            'plan_name' => 'required|unique:vangography_plans,plan_name,' . $vangographyPlan->id,
            'size' => 'required|numeric|min:0.5|unique:vangography_plans,size,' . $vangographyPlan->id,
            'price' => 'required',
        ]);

        $vangographyPlan->update($data);

        return redirect()->route('dashboard.vangography.plan.index')->with('success', 'Plan updated successfully.');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VangographyPlan  $vangographyPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(VangographyPlan $vangographyPlan)
    {
        $vangographyPlan->delete();
        return redirect()->route('dashboard.vangography.plan.index')->with('success', 'Plan deleted successfully.');
    }
}
