<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeviceStatusNotification extends Model
{
    
    protected $table = 'dsn_status';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable =['baby_mrn','baby_mrn','notification_start_tstamp','notification_end_tstamp', 'status','notification_stopped_user_id'];

}
