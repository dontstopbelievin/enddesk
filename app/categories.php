<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
  protected $fillable = [
      'name',
  ];
  
  public function requests(){
    return $this->hasMany('App\requests', 'category_id');
  }
}
