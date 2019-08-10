<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $guarded=['id'];

    public function dropdown()
    {
        return $this->hasMany(dropdown::class);
    }
}
