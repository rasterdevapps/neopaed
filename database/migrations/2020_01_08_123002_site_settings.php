<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
                $table->integer('SiteId');
                $table->string('LogoImage', 500);
                $table->text('PrintLogo')->nullable(true);
                $table->string('SiteName', 500);
                $table->text('BMRSettings');
                $table->text('MMRSettings');
                $table->dateTime('DateModified');
                $table->integer('OverwriteBabyMR')->default(0);
                $table->integer('OverwriteMotherMR')->default(0);
                $table->integer('dSummaryedit')->default(0);
                $table->smallInteger('mirthIntegration')->nullable(true)->default(1);
                $table->text('discharge_report_left')->nullable(true);
                $table->text('discharge_report_right')->nullable(true);
                $table->text('discharge_instraction')->nullable(true);
                $table->text('discharge_summary_footer')->nullable(true);
                $table->text('pagenation_limit_options')->nullable(true);
                $table->text('hospital_contact')->nullable(true);
                $table->text('hospital_name')->nullable(true);
                $table->text('PrintLogoOption')->nullable(true);
                $table->text('licence_key')->nullable(true);
                $table->smallInteger('header_required')->default(1);
                $table->text('nurse_entry_start')->nullable(true);
                $table->text('api_key')->nullable(true);
                $table->text('api_user_name')->nullable(true);
                $table->text('api_password')->nullable(true);
                $table->jsonb('custom_toastr')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
