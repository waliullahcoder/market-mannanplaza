<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "tbl_posts";

    protected $fillable = [
        'page_id','post_name','title','inner_title','description','url_link','icon','image','width','height','inner_image','inner_width','inner_height','meta_title','meta_keyword','meta_description','order_by','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
