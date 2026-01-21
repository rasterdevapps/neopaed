<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function(Blueprint $table) {
                $table->bigIncrements('RoleId');
                $table->string('RoleName', 50);
                $table->text('Permissions');
                $table->string('Status', 25);
                $table->integer('UserAdded')->nullable(true);
                $table->integer('UserModified')->nullable(true);
                $table->datetime('DateAdded')->nullable(true);
                $table->datetime('DateModified')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
