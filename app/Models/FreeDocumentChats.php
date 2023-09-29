<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeDocumentChats extends Model
{
    use HasFactory;

    protected $table = 'free_document_chats';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'document_id',
        'outline',
        'slug',
        'document_unique',
    ];
}
