<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{





    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
