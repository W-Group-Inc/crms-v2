<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class RpeFile extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    protected $table = "rpefiles";

    protected $primaryKey = "Id";
    const UPDATED_AT = "ModifiedDate";
    const CREATED_AT = "CreatedDate";

    public function transformAudit(array $data): array
    {
        if (isset($data['auditable_id'])) {
            $data['auditable_id'] = $this->RequestProductEvaluationId;
        }

        return $data;
    }
}
