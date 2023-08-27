<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeechToText extends Model
{
    use HasFactory;

    protected $table = 'speech_to_text';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'list',
        'user_id',
    ];
}
