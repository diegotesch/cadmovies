<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athor extends Model
{
  protected $fillable = ['name', 'birthdate'];

  public function casts()
  {
    return $this->belongsToMany('App\Cast');
  }
}
