<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuActionType extends Model
{
	protected $table = "tbl_menu_action_type";

    protected $fillable = [
    	'name','action_id','status'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
