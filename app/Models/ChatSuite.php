<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSuite extends Model
{
    use HasFactory;

    protected $table = 'chat_suite';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'outline',
    ];
}
