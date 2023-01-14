<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;

class PlanController extends Controller
{
    public function getPlans(){
        return response()->json(Plan::get());
    }

    public function getPlanBySlug(Request $request){
        dd(auth());
        $intent = auth()->user()->createSetupIntent();
        $plan = Plan::where('slug', $request->slug)->first();

        return response()->json([
            'intent'    =>  $intent,
            'plan'      =>  $plan
        ]);
    }

    public function subscription(Request $request){
        $plan = Plan::find($request->plan);
  
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);
  
        return view("subscription_success");
    }
}
