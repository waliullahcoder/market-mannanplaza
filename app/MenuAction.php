<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuAction extends Model
{
	protected $table = "tbl_menu_actions";

    protected $fillable = [
    	'parent_menu_id','menu_type','action_name','action_link','order_by','status'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
