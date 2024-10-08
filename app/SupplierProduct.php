<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProduct extends Model
{
    use SoftDeletes;

    protected $table = "spe";
    protected $fillable = [
        'ProductName', 'DateRequested', 'AttentionTo', 'Deadline', 'Manufacturer', 'Quantity', 'Supplier', 'ProductApplication',
        'Origin', 'LotNo', 'Price'
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'Supplier', 'Id');
    }

    public function supplier_instruction() 
    {
        return $this->hasMany(SpeInstructions::class, 'SpeId', 'id');
    }

    public function attachments() 
    {
        return $this->hasMany(SpeFiles::class, 'SpeId', 'id');
    }
}
