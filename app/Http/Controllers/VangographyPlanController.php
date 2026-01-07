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
        $pageTitle = 'Quantumography Plans';
        $plans = VangographyPlan::all();
        return view('dashboard.quantumography.plans.index', compact('plans','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Quantumography Plan create';
        return view('dashboard.quantumography.plans.create',compact('pageTitle'));

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
            'plan_name' => 'required|unique:quantumography_plans,plan_name',
            'size' => 'numeric|required|min:0.5|unique:quantumography_plans,size',
            'price' => 'required',
        ]);

        VangographyPlan::create($data);

        return redirect()->route('dashboard.quantumography.plan.index')->with('success', 'Plan created successfully.');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VangographyPlan  $quantumographyPlan
     * @return \Illuminate\Http\Response
     */
    public function show(VangographyPlan $quantumographyPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VangographyPlan  $quantumographyPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(VangographyPlan $quantumographyPlan)
    {
        $pageTitle = 'Quantumography Plan Edit';
        return view('dashboard.quantumography.plans.edit', compact('quantumographyPlan','pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VangographyPlan  $quantumographyPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VangographyPlan $quantumographyPlan)
    {
       $data=$request->validate([
            'plan_name' => 'required|unique:quantumography_plans,plan_name,' . $quantumographyPlan->id,
            'size' => 'required|numeric|min:0.5|unique:quantumography_plans,size,' . $quantumographyPlan->id,
            'price' => 'required',
        ]);

        $quantumographyPlan->update($data);

        return redirect()->route('dashboard.quantumography.plan.index')->with('success', 'Plan updated successfully.');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VangographyPlan  $quantumographyPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(VangographyPlan $quantumographyPlan)
    {
        $quantumographyPlan->delete();
        return redirect()->route('dashboard.quantumography.plan.index')->with('success', 'Plan deleted successfully.');
    }
}
