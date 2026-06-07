<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WbillCollection extends Model
{
    protected $table = "collection_wbill";
    protected $guarded = [];

    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'Updatedate';

    public function position_holder()
    {
        return $this->hasOne('App\PositionInformation', 'Code', 'Client_Code');
    }
}
