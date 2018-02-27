<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usertypes extends Model
{
  protected $fillable = [
      'name',
  ];

  public function users(){
    return $this->hasMany('App\User', 'usertype_id');
  }
}
