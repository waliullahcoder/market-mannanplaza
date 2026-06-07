<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminPanelInformation extends Model
{
	protected $table = "tbl_admin_panel_information";

    protected $fillable = [
    	'website_name','prefix_title','website_title','developed_by','developer_website_link','logo_one','logo_one_width','logo_one_height','logo_two','logo_two_width','logo_two_height','fav_icon','fav_icon_width','fav_icon_height','status','created_by','updated_by'
    ];

	protected $hidden = [
		'created_at','updated_at'
	];
}
