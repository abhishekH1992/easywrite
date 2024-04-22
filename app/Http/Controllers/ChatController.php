<?php

namespace App\Http\Controllers;

use DOMDocument;
use Carbon\Carbon;

use Illuminate\Http\Request;

use \App\Models\Prompt;
use \App\Models\Chats;
use App\Http\Controllers\DocumentsController;

class ChatController extends Controller
{
    public $documentController;

    public function __construct(){
        $this->documentController = new DocumentsController();
        return $this->middleware('auth:api');
    }
    
    public function create(Request $request, \OpenAI\Client $client){
        try{
            $slug = explode('/', $request->slug);
            if($request->isPython){
                if(count($slug) > 3) {
                    unset($slug[count($slug)-1]);
                    $str = implode('/', $slug);
                    $prompt = Prompt::where('slug', $str)->first();
                } else {
                    $prompt = Prompt::where('slug', $request->slug)->first();
                }

                $payload = [
                    'msg'       =>  $request->msg,
                    'user_id'   =>  auth()->id(),
                ];
                $response = $this->documentController->sendRequest($prompt->endpoint, $payload);
                $data = [];
                if($response->success) {
                    if($request->isPythonSuggestions) {
                        $data['suggestions'] = $response->data->suggestions;
                    } else {
                        // $isReference = strpos($response->data->text, "References:");
                        // $isReference = !$isReference ? strpos($response->data->text, "References") : $isReference;
                        // $data['text'] = $isReference ? preg_replace('/[[0-9].]/', '', substr($response->data->text, 0, $isReference)) : preg_replace('/[[0-9].]/', '', $response->data->text);
                        $text = str_replace("\n", '', $response->data->text);
                        $text = $this->setTargerToAnchor($text);
                        $data['text'] = $text;
                        $data['related_questions'] = isset($response->data->related_questions) ? $response->data->related_questions : [];
                        $data['source_urls'] = isset($response->data->source_urls) ? $this->objectToArray($response->data->source_urls) : [];
                        $data['related_urls'] = isset($response->data->related_urls) ? $this->objectToArray($response->data->related_urls) : [];
                    }
                } else {
                    $data['text'] = 'Error: Please refresh or reduce your text input';
                    $data['related_questions'] = [];
                    $data['source_urls'] = [];
                    $data['related_urls'] = [];
                }
                return $data;

            } elseif($request->slug === '/speech-to-text') {
                $prompt = Prompt::where('slug', $request->slug)->first();
            } elseif(count($slug) == 3) {
                $prompt = Prompt::where('slug', $request->slug)->first();
            } else {
                unset($slug[count($slug)-1]);
                $str = implode('/', $slug);
                $prompt = Prompt::where('slug', $str)->first();
            }
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

            $msg = [
                'role' => 'user',
                'content' =>  $data['prompt'],
            ];
            $data = [
                'model' =>  $data['model'],
                'messages'  =>  [$msg],
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

    public function pageInfo(Request $request){
        $data = $request->slug;
        $slug = explode('/', $data);
        if(count($slug) > 3) {
            unset($slug[count($slug)-1]);
            $data = implode('/', $slug);
        }
        return response()->json(Prompt::where('slug', $data)->first());
    }

    public function getModels(){
        return response()->json(Prompt::all());
    }

    public function save(Request $request){
        $prompt = Prompt::where('slug', $request->slug)->first();

        $data = Chats::updateOrCreate(
            [
                'id'            =>  $request->id,
                'user_id'       =>  auth()->id(),
            ],
            [
                'user_id'       =>  auth()->id(),
                'prompt_id'     =>  $prompt->id,
                'name'          =>  $request->name ? $request->name : $prompt->name.time(),
                'editor'        =>  $request->editor,
                'list'          =>  json_encode($request->list),
                'language'      =>  $request->language,
                'tone'          =>  $request->tone,
            ]
        );

        return response()->json($data);
    }

    public function getUserChat(Request $request){
        $data = Chats::where('id', $request->id)->where('user_id', auth()->id())->first();
        
        return response()->json($data);
    }

    public function getUserChats(Request $request){
        $arr = [];
        if($request->term){
            $data = Chats::latest()->with('prompt')->where('user_id', auth()->id())->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = Chats::latest()->with('prompt')->where('user_id', auth()->id())->get();
        }

        foreach($data as $d) {
            $d->human_readable_date = Carbon::parse($d->created_at)->diffForHumans();
            array_push($arr, $d);
        }

        return response()->json($arr);
    }

    public function destroy(Request $request){
        return response()->json(Chats::where('id', $request->id)->where('user_id', auth()->id())->delete());
    }

    public function objectToArray($obj) {
        $data = [];
        foreach($obj as $k => $v) {
            $data[] = ['txt' => '['.$k.'] '.$v, 'link' => $v];
        }
        return $data ? json_decode(json_encode($data, true)) : [];
    }

    public function setTargerToAnchor($content) {
        $doc = new DOMDocument();
        $doc->loadHTML($content);
        $links = $doc->getElementsByTagName('a');
        foreach ($links as $item) {
            if (!$item->hasAttribute('target'))
                $item->setAttribute('target','_blank');  
        }
        $content = $doc->saveHTML();
        return $content;
    }
}
