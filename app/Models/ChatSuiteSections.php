<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ChatSuite;

class ChatSuiteSections extends Model
{
    use HasFactory;

    protected $table = 'chat_suite_sections';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'outline',
        'model',
        'file_id',
        'job_id',
        'chat_suite_id',
        'system_msg',
        'file',
        'processing'
    ];

    public function chat_suite(){
        return $this->hasOne(ChatSuite::class, 'id', 'chat_suite_id');
    }
}
