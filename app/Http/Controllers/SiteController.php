<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Models\Prompt;
use App\Models\Tone;
use App\Models\Language;

use Laravel\Passport\HasApiTokens;

class SiteController extends Controller
{
    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function getModels(Request $request){
        $data = Prompt::all();
        $arr = [];
        foreach($data as $d){
            $arr[$d->template][] = $d;
        }
        return response()->json($arr);
    }

    public function getSearchModels(Request $request){
        if($request->term){
            $data = Prompt::whereNull('isSystem')->whereNull('is_display_in_list')->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = Prompt::whereNull('isSystem')->whereNull('is_display_in_list')->get();
        }
        return response()->json($data);
    }

    public function getToneList(Request $request){
        return response()->json(Tone::all());
    }

    public function getLanguageList(Request $request){
        return response()->json(Language::all());
    }

    public function isUserLoggedIn(){
        return response()->json(auth()->check());
    }

    public function isSevenDayTrial(){
        if(!auth()->check()){
            return response()->json(false);
        }
        $isEligible = strtotime('+1 days', strtotime(auth()->user()->created_at));
        $currentDate = strtotime("now");
        $data = false;
        if($isEligible > $currentDate){
            $data = true;
        }

        return response()->json($data);
    }

    public function getCustomChatSearchModels(Request $request) {
        if($request->term){
            $data = Prompt::where('isSystem', 1)->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = Prompt::where('isSystem', 1)->get();
        }
        return response()->json($data);
    }

    public function getNavMenuModels(Request $request){
        return response()->json(Prompt::where('isMenu', 1)->get());
    }
}
