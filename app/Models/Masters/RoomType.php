<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
   protected   $table       = 'room_type';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['name','price_book_id'];
}
