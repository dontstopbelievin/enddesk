<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class requests extends Model
{
  protected $fillable = array('username', 'email', 'category_id', 'theme', 'priority_id', 'cabinet', 'tel', 'message', 'status_id', 'admin_id', 'closed_time');

  public function category(){
    return $this->belongsTo('App\categories');
  }
  public function priority(){
    return $this->belongsTo('App\priorities');
  }
  public function status(){
    return $this->belongsTo('App\statuses');
  }
  public function admin(){
    return $this->belongsTo('App\User');
  }
}
