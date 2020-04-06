<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
  protected $fillable = ['name', 'starring', 'profit', 'category_id'];

  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  public function cast()
  {
    return $this->hasOne('App\Cast');
  }
}
