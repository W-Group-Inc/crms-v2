<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class SrfDetail extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    protected $table = "srfdetails";
    const UPDATED_AT = "ModifiedDate";
    const CREATED_AT = "DateCreated";

    protected $fillable = [
        'SampleRequestId',
        'DateCreated',
        'UserId',
        'DetailsOfRequest',
    ];

    public function userSupplementary()
    {
        return $this->belongsTo(User::class, 'UserId', 'user_id');
    }

    public function transformAudit(array $data): array
    {
        if (isset($data['auditable_id'])) {
            $data['auditable_id'] = $this->SampleRequestId;
        }

        return $data;
    }
}
