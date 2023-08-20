<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Models\TranslateLanguage;

class TranslatorController extends Controller
{
    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function translate(Request $request) {
        $tr = new GoogleTranslate($request->language['code']);
        return response()->json($tr->translate($request->txt));
    }

    public function translateLanguage(Request $request) {
        return response()->json(TranslateLanguage::all());
    }
}
