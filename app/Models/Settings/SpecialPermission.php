<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SpecialPermission extends Model
{
    protected $table      = 'special_permissions';
    protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['id','user_id','permissions','UserAdded','UserDeleted','UserModified','DateAdded','DateModified','IsDeleted'];
}
