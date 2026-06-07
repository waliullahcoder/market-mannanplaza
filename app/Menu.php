<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table = "tbl_menus";

    protected $fillable = [
    	'parent_menu','menu_name','menu_link','menu_icon','order_by','status'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
