<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable = ['name'];

    public function movies() {
        return $this->hasMany(Movie::class);
    }
}
