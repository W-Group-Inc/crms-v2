<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileRpe extends Model
{
    use SoftDeletes;
    protected $table = "rpefiles";
}
