<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionInformation extends Model
{
    protected $table = "saleposition";
    protected $primaryKey = "ID";
    protected $guarded = [];


    public function toggleStatus()
    {
        if ($this->status == 1) {

            $this->update([
                'status' => 0,
            ]);
        } else {

            $this->update([
                'status' => 1,
            ]);
        }

        $this->save();
    }


    public function last_wbill_unit()
    {
        return $this->hasOne('App\WbillCollection', 'Client_Code', 'Code')->orderBy('id', 'desc');
    }
}
