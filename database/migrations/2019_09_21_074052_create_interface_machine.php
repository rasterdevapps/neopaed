<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterfaceMachine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interface_machine', function(Blueprint $table)
        {
            $table->jsonb('received')->nullable();
            $table->timestamp('received_time')->nullable();
            $table->boolean('is_parsed')->default('false');
            $table->string('received_ip')->nullable();
            $table->date('received_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interface_machine');
    }
}
