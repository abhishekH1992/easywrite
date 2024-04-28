<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\Documents;
use App\Models\DocumentList;

class DocumentsController extends Controller
{
    CONST REST_API = 'https://moanaai.com';
    CONST DEFAULT_USER = '9593107c-32d7-424e-9b57-cba2089fafad';

    public $client;

    public function __construct(){
        $client = new \GuzzleHttp\Client();
        return $this->middleware('auth:api');
    }

    public function getUserDocuments(Request $request) {
        $arr = [];
        if($request->term){
            $data = Documents::latest()->where('user_id', auth()->id())->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = Documents::latest()->where('user_id', auth()->id())->get();
        }

        foreach($data as $d) {
            $d->human_readable_date = Carbon::parse($d->created_at)->diffForHumans();
            array_push($arr, $d);
        }
        return response()->json($arr); 
    }

    public function pageInfo(Request $request) {
        return response()->json(Documents::where('document_id', $request->documentid)->first());
    }

    public function getDocumentList(Request $request) {
        $document = Documents::where('document_id', $request->documentid)->first();
        $data = DocumentList::latest()->where('document_id', $document->id)->get();
        return response()->json($data);
    }

    public function sendRequest($endpoint, $payload) {
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

        $response = curl_exec($ch);//dd($response);
        curl_close($ch);
        return json_decode($response);
    }

    public function store(Request $request) {
        $endpoint = '/categories';
        $payload = [
            'command'   =>  'ADD',
            'message'   =>  [
                $request->name, "",$request->name
            ],
            "user_id"   =>  SELF::DEFAULT_USER,
        ];

        $response = $this->sendRequest($endpoint, $payload);

        if($response && $response->status && $response->message && $response->message[0] && $response->message[0][1]) {
            Documents::create([
                'name'          =>  $request->name,
                'document_id'   =>  $response->message[0][1],
                'user_id'       =>  auth()->id()
            ]);

            return response()->json(true);
        }

        return false;
    }

    public function upload(Request $request) {
        $newLink = $request->newlink;
        if(!$newLink) {
            $file = $request->file;
            $data = file_get_contents($file->getPathName());
            $base64 = 'data:text/plain;base64,' . base64_encode($data);
            $payload = [
                'command'   =>  'SUBMIT_FILE',
                'message'   =>  [
                    "filename"  =>  [$file->getClientOriginalName()],
                    "file_data" =>  [$base64],
                    "class_id"  =>  $request->documentid,
                ],
                "user_id"   =>  SELF::DEFAULT_USER
            ];
        } else {
            $payload = [
                'command'   =>  'SUBMIT_LINK',
                'message'   =>  [
                    "class_id"  =>  $request->documentid,
                    "newlink"   =>  $newLink,
                ],
                "user_id"   =>  SELF::DEFAULT_USER
            ];
        }
        $endpoint = '/doc-parse';
        $response = $this->sendRequest($endpoint, $payload);
        if($response && $response->status == 'success' && $response->message && $response->message[0] && $response->message[1][1]) {
            $doc_id = Documents::where('document_id', $request->documentid)->first();

            DocumentList::create([
                'name'              =>  $newLink ? $newLink : $file->getClientOriginalName(),
                'document_unique'   =>  $response->message[1][1],
                'document_id'       =>  $doc_id->id,
                'user_id'           =>  auth()->id(),
            ]);

            return response()->json(true);
        }

        return false;
    }

    public function remove(Request $request) {
        $endpoint = '/doc-parse';
        $payload = [
            'command'   =>  'REMOVE_DOC',
            'message'   =>  [
                "file_id"  =>  $request->file_id,
            ],
            "user_id"   =>  SELF::DEFAULT_USER
        ];
        $response = $this->sendRequest($endpoint, $payload);

        if($response && $response->status == 'success') {
            DocumentList::where('document_unique', $request->file_id)->delete();
            return response()->json(true);
        }

        return false;
    }

    public function chat(Request $request) {
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

    public function destroy(Request $request) {
        $endpoint = '/categories';
        $payload = [
            'command'   =>  'REMOVE',
            'message'   =>  [
                $request->name, $request->document_id
            ],
            "user_id"   =>  SELF::DEFAULT_USER,
        ];

        $response = $this->sendRequest($endpoint, $payload);

        if($response && $response->status) {
            Documents::where('document_id', $request->document_id)->delete();
            return response()->json(true);
        }

        return false;
    }

    public function save(Request $request){
        $data = Documents::where('id', $request->id)->where('user_id', auth()->id())->update([
            'list'  =>  $request->list,
            'name'  =>  $request->name,
        ]);

        return response()->json($data);
    }
}
