<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class priorities extends Model
{
  protected $fillable = [
      'name',
  ];
  
  public function requests(){
    return $this->hasMany('App\requests', 'priority_id');
  }
}
