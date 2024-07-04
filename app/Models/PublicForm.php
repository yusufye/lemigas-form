<?php

namespace App\Models;

use App\Models\Code;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'kepentingan_1',
        'kepentingan_2',
        'kepentingan_3',
        'kepentingan_4',
        'kepentingan_5',
        'kepentingan_6',
        'kepentingan_7',
        'kepentingan_8',
        'kepentingan_9',
        'kepuasan_1',
        'kepuasan_2',
        'kepuasan_3',
        'kepuasan_4',
        'kepuasan_5',
        'kepuasan_6',
        'kepuasan_7',
        'kepuasan_8',
        'kepuasan_9',
        'korupsi_1',
        'korupsi_2',
        'korupsi_3',
        'korupsi_4',
        'korupsi_5',
        'korupsi_6',
        'korupsi_7',
        'korupsi_8',
        'korupsi_9',
        'company_name',
        'company_address',
        'company_phone',
        'remark',
        'submitted_at',
        'signature_path',
        'code_id',
        'jenis_pelayanan',
        'responden_age',
        'responden_gender',
        'responden_education',
        'complaint',
    ];

    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class,'code_id');
    }
}
