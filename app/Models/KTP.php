<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class KTP extends Model
{
    protected $fillable = ['no_ktp','image', 'nama', 'jenis_kelamin', 'alamat', 'kk_id'];

    public function kk()
    {
        return $this->belongsTo(KK::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/kk/' . $image),
        );
    }
}
