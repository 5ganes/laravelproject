<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // to change the default settings
    // protected $table = 'newTable';
    // public $primaryKey = 'newKey';
    // public $timestamps = true/false;

    public function user(){
        return $this->belongsTo( 'App\User');
    }
}