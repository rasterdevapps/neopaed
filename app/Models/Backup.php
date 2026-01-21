<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Backup extends Model
{
	protected $table = 'temp_backups';
	protected $primaryKey = 'TempId';
	public $timestamps  =  false;
	
	protected $fillable = ['Content','UserId','Id','ModuleCode','DateAdded'];

}
