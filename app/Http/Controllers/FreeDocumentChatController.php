<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\FreeDocumentChats;

class FreeDocumentChatController extends Controller
{
    CONST REST_API = 'https://moanaai.com';
    CONST DEFAULT_USER = '9593107c-32d7-424e-9b57-cba2089fafad';

    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function getList(Request $request){
        $arr = [];
        if($request->term){
            $data = FreeDocumentChats::latest()->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = FreeDocumentChats::all();
        }

        foreach($data as $d) {
            $d->human_readable_date = Carbon::parse($d->created_at)->diffForHumans();
            array_push($arr, $d);
        }
        return response()->json($arr); 
    }

    public function create(Request $request) {
        try {
            $endpoint = '/categories';
            $payload = [
                'command'   =>  'ADD',
                'message'   =>  [
                    $request->name, "",$request->name
                ],
                "user_id"   =>  SELF::DEFAULT_USER,
            ];

            $category = $this->sendRequest($endpoint, $payload);

            \Log::info("CATEGORY \n");
            \Log::info(print_r($category, true));

            if($category && $category->status && $category->message && $category->message[0] && $category->message[0][1]) {
                $file = $request->file;
                $data = file_get_contents($file->getPathName());
                $base64 = 'data:text/plain;base64,' . base64_encode($data);
                $payload = [
                    'command'   =>  'SUBMIT_FILE',
                    'message'   =>  [
                        "filename"  =>  [$file->getClientOriginalName()],
                        "file_data" =>  [$base64],
                        "class_id"  =>  $category->message[0][1],
                    ],
                    "user_id"   =>  SELF::DEFAULT_USER
                ];
                $endpoint = '/doc-parse';
                $response = $this->sendRequest($endpoint, $payload);
                \Log::info("RESSPONSE \n");
                \Log::info(print_r($response, true));
                if($response && $response->status == 'success' && $response->message && $response->message[0] && $response->message[1][1]) {
                    FreeDocumentChats::create([
                        'name'              =>  $request->name,
                        'outline'           =>  $request->outline,
                        'slug'              =>  $request->slug,
                        'document_unique'   =>  $response->message[1][1],
                        'document_id'       =>  $category->message[0][1],
                    ]);

                    return response()->json(true);
                }
            }
            return response()->json(false);
        } catch(\Exception $e) {
            \Log::info(print_r($e, true));
            return response()->json(false);
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
