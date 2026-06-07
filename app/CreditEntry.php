<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditEntry extends Model
{
    protected $table = "tbl_account_transactions";

    protected $fillable = [
        'voucher_no','voucher_type','voucher_date','coa_id','coa_head_code','unit_id','narration','debit_amount','credit_amount','posted','approve','active','delete','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];

    public function coa()
    {
        return $this->belongsTo(CoaSetup::class, 'coa_head_code', 'head_code');
    }
}
