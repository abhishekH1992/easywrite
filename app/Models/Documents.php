<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentList;

class Documents extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'document_id',
        'user_id'
    ];

    public function documentList(){
        return $this->hasMany(DocumentList::class, 'document_id', 'id');
    }
}
