<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitSetup extends Model
{
	protected $table = "tbl_setup_unit";

    protected $fillable = [
    	'code','name','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
