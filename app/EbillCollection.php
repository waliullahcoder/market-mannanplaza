<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbillCollection extends Model
{
    protected $table = "collection_ebill";
    protected $guarded = [];

    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'Updatedate';

    public function position_holder()
    {
        return $this->hasOne('App\PositionInformation', 'Code', 'Client_Code');
    }
}
