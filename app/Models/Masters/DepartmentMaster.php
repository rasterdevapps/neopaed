<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class DepartmentMaster extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table      = 'mas_department';

    /**
     * Define the table primary key
     *
     * @var $primary key
     */
    protected $primaryKey = 'Id';

    /**
     * Define the table timestamps
     *
     * @var $timestamps
     */
    public $timestamps    = false;

    /**
     * Define the table fillable columns
     *
     * @var $fillable
     */
    protected $fillable   = ['Name', 'Status', 'UserAdded', 'UserModified', 'UserDeleted', 'IsDeleted', 'DateAdded', 'DateModified', 'code', 'hms_key'];

    /**
     * This method to get department list
     *
     * @param $ward_id
     */
    public static function getDepartmentList()
    {
       return \DB::table('mas_department')
                 ->where('IsDeleted', 0)
                 ->get();
    }
    
}
