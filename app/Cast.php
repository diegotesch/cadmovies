<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
  protected $fillable = ['movie_id'];

  public function movie()
  {
    return $this->belongsTo('App\Movie');
  }

  public function athors()
  {
    return $this->belongsToMany('App\Athor');
  }
}
