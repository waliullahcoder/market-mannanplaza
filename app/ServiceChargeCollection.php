<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceChargeCollection extends Model
{
    protected $table = "collection_servicecharge";
    protected $guarded = [];

    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'Updatedate';

    public function position_holder()
    {
        return $this->hasOne('App\PositionInformation', 'Code', 'Client_Code');
    }

    public function utility()
    {
        return $this->hasOne('App\UtilitySetup', 'id', 'Utility_ID');
    }
}
