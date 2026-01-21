<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_settings', function (Blueprint $table) {

            $table->increments('problem_id');
            $table->text('problem_name')->nullable(true);
            $table->text('problem_description')->nullable(true);
            $table->jsonb('problem_fields')->nullable(true);
            $table->boolean('problem_status')->nullable(true);
            $table->smallInteger('IsDeleted')->default(0);      
            $table->integer('UserAdded')->nullable(true);  
            $table->dateTime('DateAdded')->nullable(true);     
            $table->integer('UserDeleted')->nullable(true);    
            $table->integer('UserModified')->nullable(true);    
            $table->dateTime('DateModified')->nullable(true);


           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problem_settings');
    }
}
