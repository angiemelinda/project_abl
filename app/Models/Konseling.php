<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'konselor_id',
        'jadwal',
        'topik',
        'status',
        'catatan',
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'topik_konseling',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function konselor()
    {
        return $this->belongsTo(User::class, 'konselor_id');
    }
}
