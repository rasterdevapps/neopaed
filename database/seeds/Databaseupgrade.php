<?php

use Illuminate\Database\Seeder;
use App\Models\Baby;
use App\Models\Usg;
use App\Models\Daycare;
use App\Models\DaycareQuestions;



class Databaseupgrade extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	  // $baby =  \DB::table('baby')->get();

       //      foreach ($baby as $value) {

       //          $input = (array)json_decode($value->Gestation);

       //          $input['g_weeks'] = empty(trim($input['g_weeks'])) ? NULL : (int)$input['g_weeks'];

       //          $input['g_days']  = empty(trim($input['g_days'])) ? NULL : (int)$input['g_days'];

       //          $result = Baby::find($value->BabyId);

       //          $result->update($input);

       //          unset($input);
                
       //      }

       //      // unserialze the data and store 
        
       //    $baby = \DB::table('usg_finding')->get();

       //    foreach ($baby as $key => $value) {

       //          $test = unserialize($value->Finding);

       //        foreach ($test as $key1 => $value1) {

       //            if(!empty($value1)){

       //              $input['Finding']   = $value1 ;
       //              $input['Gestation'] = unserialize($value->Finding)[$key1];
       //              $result =  \DB::table('usg_finding')->where(['MotherId'=>$value->MotherId,'flags'=>$value->flags])->update($input);
       //              unset($input);
                    
       //            }  
                    
       //        }

       //    }

      //update op visite counts 

    



      



        
    }
}
