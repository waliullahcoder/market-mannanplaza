<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantStamps extends Model
{
    protected $table = "tenant_stamps";
    protected $guarded = [];

    public function tenant()
    {
        return $this->hasOne('App\PositionInformation', 'id', 'tenant_id');
    }
}
