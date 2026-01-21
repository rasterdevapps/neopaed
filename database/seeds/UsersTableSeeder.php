<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
           
            0 => 
            array (
                'id' => 8,
                'RoleId' => 1,
                'name' => 'manikandan',
                'email' => 'manikandan.m@raster.in',
                'password' => '$2y$10$ZLyS1hh.ojs4zEymNqhzaubUdJFw78YQBAo4SEwup6NA99uxqITB.',
                'remember_token' => '3cefhGbPyOhetV8jkSIE2jSeZ7aTh5GwcdEwYAJpC4EsVY4ySjhEBYK05jNe',
                'created_at' => '2017-04-21 12:31:06',
                'updated_at' => '2017-08-04 18:47:55',
            ),
            1 => 
            array (
                'id' => 12,
                'RoleId' => 5,
                'name' => 'Mrs.Testnurse',
                'email' => 'testnurse@gmail.com',
                'password' => '$2y$10$ThSUZgynlACJtUkQLlaMUuj7iEyRxdiz5EMyD/CyUt1a/jzJDUAnK',
                'remember_token' => 'tGhJZe40FP8wokGnqrinIhzVvtTdDoF3prmQMsOx1HH28JdKBKo0tsYubdxf',
                'created_at' => '2017-08-03 15:03:23',
                'updated_at' => '2017-08-04 18:49:09',
            ),
        ));
    }
}
