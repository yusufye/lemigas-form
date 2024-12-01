<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CodeFile extends Model
{
    use HasFactory;
    protected $fillable = ['code_id', 'file_path'];

    public function code()
    {
        return $this->belongsTo(Code::class);
    }
}
