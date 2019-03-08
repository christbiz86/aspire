<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{

    public function getUserId()
    {
        return $this->belongsTo(User::class,'userId');
    }

}
