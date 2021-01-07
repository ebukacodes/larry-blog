<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // primary key
    public $primaryKey = 'id';
    // timestamps
    public $timestamps = 'true';

    // map post to user
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
