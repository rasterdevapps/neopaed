<?php

namespace App\Models\Masters;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;




class AutoTagMasters extends Model
{
    protected $table = 'auto_tags_values';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['id','name','value','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted','usage'];
    
    public static function get_values_lists()
    {

    	return DB::table('auto_tags_values')->where('IsDeleted', 0)->pluck('name', 'value');

    }


    public static function auto_key_support($tag_fileds, $tag_values)
    {
       
       $tags_temp =array();
       foreach ($tag_fileds as $value) {
          if (isset($tag_values[$value])) {
       	    $tags_temp=array_merge($tags_temp, explode(',', ($tag_values[$value])));
       	  } 
       }
       // $tags_temp = array_unique($tags_temp);

       foreach ($tags_temp as $key => $values) {
       	    if (empty(trim($values))) {
                unset($tags_temp[$key]);
       	    }
       }
      // $tags_temp = array_unique($tags_temp);


       $existstag=DB::table('auto_tags_values')->whereIn('name', $tags_temp)->get();
         //$existstagvalue->name
        foreach ($existstag as $existstagkey => $existstagvalue) {
           
            $tagkey=array_search($existstagvalue->name, $tags_temp);   
            if (!empty($tagkey)) {
              unset($tags_temp[$tagkey]);  
            }

          $tagupdate = self::find($existstagvalue->id);
          $tagupdate->usage = $tagupdate->usage+1;
          $tagupdate->update();

			  	
         } 
         $addtags['UserAdded'] = \Auth::user()->Id;
         $addtags['IsDeleted'] = 0;
         $addtags['usage']     = 1;

         foreach ($tags_temp as $value) {
         	$addtags['name'] = $addtags['value'] = $value ;
         	$addtags['DateAdded'] = date('Y-m-d h:i:s');
         	self::create($addtags);
         }

         return true;
	}
}
