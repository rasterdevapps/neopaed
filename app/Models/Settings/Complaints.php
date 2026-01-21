<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $table = 'complaints';
    protected $primaryKey = 'id';
    public $timestamps  =  false;
    protected $fillable = ['complaint','complaint_by','complaint_date_time','status'];
    
}
