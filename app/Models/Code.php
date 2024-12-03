<?php

namespace App\Models;

use App\Models\User;
use App\Models\PublicForm;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Code extends Model
{
    use HasFactory;
    protected $fillable = ['code','created_by','attachment','external_link'];

    public static function findByEncryptedId($encryptedId)
    {
        try {
            //code...
            $id = Crypt::decryptString($encryptedId);
            return static::findOrFail($id);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function publicForm(): HasOne
    {
        return $this->hasOne(PublicForm::class, 'code_id');
    }

    public function user_created(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function files()
    {
        return $this->hasMany(CodeFile::class);
    }
}