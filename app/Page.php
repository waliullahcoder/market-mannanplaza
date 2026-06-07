<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "tbl_pages";

    protected $fillable = [
        'frontend_menu_id','page_name','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
