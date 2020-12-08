<?php

namespace App\Classif;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'classif.tk_settings';
    protected $primaryKey = 'key';
    protected $keyType = 'string';
}
