<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Prompt;

class ChatController extends Controller
{
    // public function __construct(){
    //     return $this->middleware('auth:api');
    // }

    public function create(Request $request, \OpenAI\Client $client){
        try{
            $prompt = Prompt::where('slug', $request->slug)->first();
            $settings = json_decode($prompt->settings);
            $array = [];
            foreach($settings as $key => $setting){
                $array[$key] = $setting;
            }
            $msg = $request->msg;

            if($prompt->divider){
                $msg = $msg.$prompt->divider;
            }

            if($prompt->aiprefix){
                $msg = $msg.$prompt->aiprefix;
            }

            if($prompt->isTextarea){
                $msg = strip_tags($msg);
            }


            $data = array_merge(
                [
                    'prompt'    => $msg
                ],
                $array
            );

            $result = $client->completions()->create($data);
            $response = $result->choices[0]->text;
            // if($prompt->isTextarea){
            //     $response = '<p>'.$response.'</p>';
            // }

            return ltrim($response);
        } catch (\Exception $e) {
            return 'Error: Please refresh or reduce your text input';
        }
    }

    public function pageInfo(Request $request){
        return response()->json(Prompt::where('slug', $request->slug)->first());
    }

    public function getModels(){
        return response()->json(Prompt::all());
    }
}
