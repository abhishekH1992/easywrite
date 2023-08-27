<?php

namespace App\Http\Controllers;

use CURLFile;
use App\File;
use Storage;
use OpenAI;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\SpeechToText;
use App\Models\Audio;

class SpeechToTextController extends Controller
{
    private $client;

    public function __construct(){
        $client = OpenAI::client('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');
        return $this->middleware('auth:api');
    }

    public function getList(Request $request){
        $arr = [];
        if($request->term){
            $data = SpeechToText::where('user_id', auth()->id())->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = SpeechToText::where('user_id', auth()->id())->get();
        }

        foreach($data as $d) {
            $d->human_readable_date = Carbon::parse($d->created_at)->diffForHumans();
            array_push($arr, $d);
        }
        return response()->json($arr);
    }

    public function newChat(Request $request) {
        $data = SpeechToText::create([
            'user_id'   =>  auth()->id(),
            'name'      =>  $request->name, 
        ]);

        return response()->json($data);
    }

    public function pageInfo(Request $request){
        return response()->json(SpeechToText::where('id', $request->id)->where('user_id', auth()->id())->first());
    }

    public function destroy(Request $request){
        try {
            SpeechToText::where('id', $request->id)->where('user_id', auth()->id())->delete();
            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json(false);
        }
    }

    public function getAudioList(Request $request){
        $data = Audio::where('speech_id', $request->speech_id)->where('user_id', auth()->id())->get();
        foreach($data as $d) {
            $d->link = Storage::url($d->link);
        }
        return response()->json($data);
    }

    public function uploadAudio(Request $request, \OpenAI\Client $client){
        if($request->hasFile('file')){
            try {
                $uniqueid = uniqid();
                $original_name = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $name = Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                $path = $request->file('file')->storeAs('uploads', $name, 'public');
                $basename = $request->file('file')->getBasename();

                $data = Audio::create([
                    'name'      =>  $original_name,
                    'link'      =>  $path,
                    'speech_id' =>  $request->speech_id,
                    'user_id'   =>  auth()->id(),
                ]);

                $filepath = storage_path('app/public/'.$path);

                $text = $this->audioToText($data->name, $filepath, $client);
                    
                return response()->json($text);

            } catch (\Exception $e) {
                return response()->json(false);
            }
        }
        return response()->json(false);
    }

    public function removeAudio(Request $request){
        try {
            $audio = Audio::where('id', $request->id)->where('user_id', auth()->id())->first();
            if(Storage::exists('/public/'.$audio->link)) {
                Storage::delete('/public/'.$audio->link);
            }
            Audio::where('id', $request->id)->where('user_id', auth()->id())->delete();
            return response()->json(true);

        } catch (\Exception $e) {
            return response()->json(false);
        }
    }

    public function resendAudio(Request $request, \OpenAI\Client $client) {
        $data = Audio::where('id', $request->audio_id)->where('user_id', auth()->id())->first();

        $filepath = storage_path('app/public/'.$data->link);

        $text = $this->audioToText($data->name, $filepath, $client);

        return response()->json($text);
    }

    public function audioToText($name, $path, $client) {
        $response = $client->audio()->transcribe([
            'model' => 'whisper-1',
            'file' => fopen($path, 'r'),
            'response_format' => 'verbose_json',
        ]);

        $text = '<b>Speech To Text: '.$name.'</b><br><p>'.$response->text.'</p>';

        return $text;
    }

    public function save(Request $request){
        $data = SpeechToText::where('id', $request->id)->where('user_id', auth()->id())->update([
            'list'  =>  $request->list,
            'name'  =>  $request->name,
        ]);

        return response()->json($data);
    }
}
