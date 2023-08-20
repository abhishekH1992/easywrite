<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentList extends Model
{
    use HasFactory;

    protected $table = 'document_list';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'document_unique',
        'document_id',
        'user_id',
        'list',
    ];
}
