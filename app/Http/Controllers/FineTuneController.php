<?php

namespace App\Http\Controllers;

use Str;
use Storage;
use OpenAI;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Models\ChatSuite;
use App\Models\ChatSuiteSections;

use Illuminate\Support\Facades\Validator;

class FineTuneController extends Controller
{
    public function __construct(){
        return $this->middleware('auth:api');
    }

    public function getList(Request $request){
        if($request->term){
            $data = ChatSuiteSections::latest()->with('chat_suite')->whereNotNull('model')->where('name', 'LIKE', "%{$request->term}%")->get();
        } else {
            $data = ChatSuiteSections::latest()->with('chat_suite')->whereNotNull('model')->get();
        }
        return response()->json($data); 
    }

    public function getChatSuiteList() {
        return response()->json(ChatSuite::all());
    }

    public function newFineTune(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'          =>  'required',
                'system_msg'    =>  'required',
                'chat_suite_id' =>  'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->all());
            }

            ChatSuiteSections::create([
                'name'          =>  $request->name,
                'outline'       =>  $request->outline,
                'system_msg'    =>  $request->system_msg,
                'chat_suite_id' =>  $request->chat_suite_id,
                'slug'          =>  $this->generateSlug($request->name),
            ]);

            return response()->json(true);
        } catch(\Exception $e) {
            return response()->json($e);
        }
    }

    private function generateSlug($name){
        $slug = Str::slug($name);
        if (ChatSuiteSections::where('slug', $slug)->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public function getPageInfo(Request $request){
        return response()->json(ChatSuiteSections::latest()->with('chat_suite')->where('id', $request->id)->first());
    }

    public function setProcessing(Request $request){
        ChatSuiteSections::where('id', $request->id)->update([
            'processing'    =>  $request->type
        ]);

        return response()->json(ChatSuiteSections::latest()->with('chat_suite')->where('id', $request->id)->first());
    }

    public function upload(Request $request){
        if($request->hasFile('file')){
            try {
                $uniqueid = uniqid();
                $original_name = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $name = Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
                $path = $request->file('file')->storeAs('finetune', $name, 'public');
                $basename = $request->file('file')->getBasename();

                $oldFile = ChatSuiteSections::where('id', $request->id)->first();

                \Log::info(var_export($oldFile, true));

                if(Storage::exists('/public/'.$oldFile->file)) {
                    Storage::delete('/public/'.$oldFile->file);
                }

                $client = OpenAI::client('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');
                $filepath = storage_path('app/public/'.$path);

                $response = $client->files()->upload([
                    'purpose'   =>  'fine-tune',
                    'file'      =>  fopen($filepath, 'r'),
                ]);

                ChatSuiteSections::where('id', $request->id)->update([
                    'file_id'       =>  $response->id,
                    'file'          =>  $path,
                    'job_id'        =>  null,
                ]);
                    
                return response()->json([
                    'status'    =>  'success',
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status'    =>  'error',
                    'msg'       =>  $e->getMessage(),
                ]);
            }
        }
        return response()->json([
            'status'    =>  'error',
            'msg'       =>  'File is missing.',
        ]);
    }

    public function createJob(Request $request){
        try{
            $chatSuit = ChatSuiteSections::find($request->id);

            $data = [
                'training_file' =>  $chatSuit->file_id,
                'model'         =>  'gpt-3.5-turbo-0613',
            ];
    
            $auth = 'Authorization: Bearer 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';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/fine_tuning/jobs');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, true));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result, true);

            \Log::info(var_export($result, true));

            ChatSuiteSections::where('id', $request->id)->update([
                'job_id'    =>  $result['id'],
            ]);

            return response()->json([
                'status'    =>  'success',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'error',
                'msg'       =>  $e->getMessage(),
            ]);
        }
    }
}
