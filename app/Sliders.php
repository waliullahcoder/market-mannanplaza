<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table = "tbl_sliders";

    protected $fillable = [
        'first_title','second_title','third_title','description','image','width','height','link','meta_title','meta_keyword','meta_description','order_by','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
