<?php

use Illuminate\Database\Seeder;

class FhirTableRestore extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::rename('interface_machine', 'interface_machine'.time());

    }
}
