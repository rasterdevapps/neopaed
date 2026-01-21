<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReferalSmsDoc extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'referal_doc_sms';

    /**
    * The primaryKey declaration
    *
    *@var integer serial
    */
	protected $primaryKey = 'sms_id';

	public $timestamps  =  false;

	protected $gaurded = ['sms_id'];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable =['message_receiver','message_sender','message','DateAdded','DateModified','UserDeleted','IsDeleted','sourceid','module'];
   

    

}
