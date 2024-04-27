<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Chats;

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
        'isFreechat',
        'fieldset',
        'outline',
        'background',
        'template',
        'isSystem',
        'system',
        'isMenu',
        'is_display_in_list',
        'is_image_editor',
        'isPython',
        'isPythonSuggestions',
        'country_court_endpoint',
    ];
}
