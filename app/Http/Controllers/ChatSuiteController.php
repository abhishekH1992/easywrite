<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\ChatSuite;
use \App\Models\ChatSuiteSections;

class ChatSuiteController extends Controller
{
    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function getList(Request $request){
        if($request->term){
            $data = ChatSuite::where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = ChatSuite::all();
        }
        return response()->json($data);
    }

    public function getPageInfo(Request $request){
        return response()->json(ChatSuite::where('slug', $request->slug)->first());
    }

    public function getSectionList(Request $request){
        if($request->term){
            $data = ChatSuiteSections::where('chat_suite_id', $request->id)->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = ChatSuiteSections::where('chat_suite_id', $request->id)->get();
        }
        return response()->json($data);
    }

    public function getPageInfoSection(Request $request){
        return response()->json(ChatSuiteSections::where('slug', $request->slug)->first());
    }

    public function chat(Request $request){
        try {
            $data = ChatSuiteSections::where('id', $request->id)->first();

            $data = [
                'model'     =>  $data->model,
                'messages'  =>  [
                    [
                        "role"      =>  "system",
                        "content"   =>  $data->system_msg
                    ],
                    $request->msg
                ],
            ];

            $auth = 'Authorization: Bearer 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';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, true));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result);
            $response = $result->choices[0]->message->content;

            return ltrim($response);
        } catch (\Exception $e) {
            return 'Error: Please refresh or reduce your text input';
        }
    }
}
