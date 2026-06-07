<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtilitySetup extends Model
{
	protected $table = "tbl_setup_utility";

    protected $fillable = [
    	'code','name','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
