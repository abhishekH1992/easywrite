<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;

class PlanController extends Controller
{
    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function getPlans(){
        return response()->json(Plan::first());
    }

    public function getPlanById(Request $request){
        return response()->json(Plan::where('id', $request->id)->first());
    }

    public function getSetupIntent( Request $request ){
        return response()->json($request->user()->createSetupIntent());
    }

    public function updateSubscription(Request $request){
        $user = $request->user();
        $plan = Plan::find($request->plan);

        $planId = $plan->stripe_plan;
        $paymentId = $request->payment;

        if(!$user->subscribed('default')){
            // $data = $user->newSubscription('default', $planId)->trialDays(1)
            //      ->create($paymentId);
            $data = $user->newSubscription('default', $planId)->create($paymentId);
        }else{
            $data = $user->subscription('default')->swap($planId);
        }
        return response()->json($data);
    }

    public function isSubscribed(){
        if(!auth()->check()){
            return response()->json(false);
        }
        if(auth()->user()->vip) {
            return response()->json(true);
        }
        $isEligible = strtotime('+1 days', strtotime(auth()->user()->created_at));
        $currentDate = strtotime("now");
        $data = false;
        if($isEligible > $currentDate){
            $data = true;
        }
        if(!$data){
            $data = auth()->user()->subscribed('default');
        }
        return response()->json($data);
    }

    public function isValidPlanSelected(Request $request){
        if(!auth()->check()){
            return response()->json(false);
        }
        $data = (Plan::find($request->id)) ? true : false;
        return response()->json($data);
    }

    public function getActiveUserPlan(){
        return response()->json(auth()->user()->subscription('default'));
    }

    public function cancelSubscription(Request $request){
        $data = auth()->user()->subscription('default')->cancel();
        return response()->json($data);
    }

    public function resumeSubscription(Request $request){
        $data = auth()->user()->subscription('default')->resume();
        return response()->json($data);
    }

    public function isUserOnGrace(){
        $data = auth()->user()->subscribed('default') ? auth()->user()->subscription('default')->onGracePeriod() : false;
        return response()->json($data);
    }

    public function getCustomerStripeId() {
        return response(auth()->user()->stripe_id);
    }

    public function getCustomerBillingPortal() {
        try {
            $response = auth()->user()->billingPortalUrl(route('dashboard'));
            // \Log::info($response);
            return response()->json(['status' => true, 'url' => $response]);
        } catch (\Exception $e) {
            // \Log::info($e);
            return response()->json(['status' => false]);
        }
    }
}