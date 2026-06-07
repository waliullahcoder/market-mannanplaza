<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentCollection extends Model
{
    protected $table = "collection_rant";
    protected $guarded = [];

    const CREATED_AT = 'Createdate';
    const UPDATED_AT = 'Updatedate';

    public function position_holder()
    {
        return $this->hasOne('App\PositionInformation', 'Code', 'Client_Code');
    }
}
