<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ModelEventer;

abstract class ScoopModel extends Model
{
    public static function boot() {
        parent::boot();
        self::observe(new ModelEventer());
    }
}
