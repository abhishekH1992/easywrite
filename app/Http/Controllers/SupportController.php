<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FreeDocumentChats;

class SupportController extends Controller
{
    CONST REST_API = 'https://moanaai.com';
    CONST DEFAULT_USER = '9593107c-32d7-424e-9b57-cba2089fafad';

    public function __construct(){
        return $this->middleware('guest:api');
    }

    public function getPageInfo(Request $request){
        return response()->json(FreeDocumentChats::where('slug', $request->slug)->first());
    }

    public function chat(Request $request){
        $endpoint = '/api/chat';
        $payload = [
            'classId'   =>  $request->document_id,
            'msg'       =>  $request->msg,
        ];
        $response = $this->sendRequest($endpoint, $payload);

        if($response && $response->success) {
            return response()->json($response);
        }

        return false;
    }

    private function sendRequest($endpoint, $payload) {
        $endpoint = SELF::REST_API.$endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }
}
