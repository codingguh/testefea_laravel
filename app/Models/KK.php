<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class KK extends Model
{
     protected $fillable = ['no_kk', 'image'];

        /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/kk/' . $image),
        );
    }

     public function ktps()
     {
         return $this->hasMany(KTP::class);
     }
}
