<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
   protected   $table       = 'asset';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['type', 'manufacturer', 'price', 'branchid', 'organizationid'];
}
