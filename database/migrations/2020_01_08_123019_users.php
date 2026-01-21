<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('RoleId');
                $table->string('name');
                $table->string('email');
                $table->string('password', 60);
                $table->string('remember_token', 100)->nullable(true)->default('NULL');
                $table->datetime('created_at');
                $table->datetime('updated_at');
                $table->boolean('isMaster')->nullable(true);
                $table->text('name_prefix')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
