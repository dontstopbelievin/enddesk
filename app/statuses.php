<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class statuses extends Model
{
  protected $fillable = [
      'name',
  ];

  public function requests(){
    return $this->hasMany('App\requests', 'status_id');
  }
}
