<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    protected $table = "tbl_social_links";

    protected $fillable = [
        'name','icon','link','status','order_by','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
