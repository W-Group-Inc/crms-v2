<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CcFile extends Model
{
    use SoftDeletes;
    
    protected $table = 'ccfiles';
}
