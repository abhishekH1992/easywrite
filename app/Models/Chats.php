<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Prompt;

class Chats extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'prompt_id',
        'name',
        'editor',
        'list',
        'language',
        'tone',
        'country_court'
    ];

    public function prompt(){
        return $this->hasOne(Prompt::class, 'id', 'prompt_id');
    }
}
