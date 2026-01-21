<?php

namespace App\Models\Settings;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table      = 'site_base_settings';
    protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['id','title','logo_path','group_id','UserAdded','UserDeleted','UserModified','DateAdded','DateModified'];
	

}
