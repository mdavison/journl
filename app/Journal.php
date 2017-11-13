<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
