<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $table = 'prompt';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'settings',
        'pretext',
        'img',
        'pretext',
        'slug',
        'placeholder',
        'prefix',
        'divider',
        'aiprefix',
        'style',
        'isTextarea',
        'language',
        'history',
        'isFreechat'
    ];
}
