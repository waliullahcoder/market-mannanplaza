<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteInformation extends Model
{
	protected $table = "tbl_website_information";

    protected $fillable = [
    	'website_name','prefix_title','website_title','website_link','developed_by','developer_website_link','phone_one','phone_two','phone_three','logo_one','logo_two','fav_icon','meta_title','meta_keyword','meta_description','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
