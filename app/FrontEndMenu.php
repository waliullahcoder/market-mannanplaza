<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontEndMenu extends Model
{
    protected $table = "tbl_frontend_menu";

    protected $fillable = [
        'parent_menu','menu_name','menu_link','order_by','status','menu_status','footer_menu_status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
