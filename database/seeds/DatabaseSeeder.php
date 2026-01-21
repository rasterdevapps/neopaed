<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\database\seeds\UserRoleTableSeeder;
use App\database\seeds\UsersTableSeeder;
use App\database\seeds\SiteSettingsTableSeeder;
use App\database\seeds\ConfigSettingsTableSeeder;
use App\database\seeds\FhirTableRestore;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call('UserRoleTableSeeder');
        // $this->call('UsersTableSeeder');
        // $this->call('SiteSettingsTableSeeder');
        // $this->call('ConfigSettingsTableSeeder');
        // $this->call('FhirTableRestore');
    }
}
