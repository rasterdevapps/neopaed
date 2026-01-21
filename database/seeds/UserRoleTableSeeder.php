<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        \DB::table('user_role')->delete();
        
        \DB::table('user_role')->insert(array (
            0 => 
            array (
                'RoleId' => 2,
                'RoleName' => 'Editor',
                'Permissions' => 'a:2:{s:16:"write_permission";a:31:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:6:"OP_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:9:"PEDI_FORM";s:2:"on";s:8:"PEDI_DAY";s:2:"on";s:14:"PEDI_DISCHARGE";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:9:"MAS_DRUGS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:11:"MAS_SURGEON";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:5:"USERS";s:2:"on";s:11:"USER_GROUPS";s:2:"on";}s:15:"read_permission";a:38:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:6:"OP_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:9:"PEDI_FORM";s:2:"on";s:8:"PEDI_DAY";s:2:"on";s:14:"PEDI_DISCHARGE";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:11:"REPORT_NICU";s:2:"on";s:9:"REPORT_OP";s:2:"on";s:11:"REPORT_PEDI";s:2:"on";s:14:"REPORT_NEWBORN";s:2:"on";s:14:"REPORT_CULTURE";s:2:"on";s:12:"REPORT_BIRTH";s:2:"on";s:11:"REPORT_BABY";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:9:"MAS_DRUGS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:11:"MAS_SURGEON";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:5:"USERS";s:2:"on";s:11:"USER_GROUPS";s:2:"on";}}',
                'Status' => 'Active',
                'UserAdded' => 0,
                'UserModified' => 0,
                'DateAdded' => '2015-07-16 12:33:48',
                'DateModified' => '2017-07-01 15:44:46',
            ),
            1 => 
            array (
                'RoleId' => 5,
                'RoleName' => 'Nurse',
                'Permissions' => 'a:2:{s:16:"write_permission";a:1:{s:14:"NICU_NURSE_DAY";s:2:"on";}s:15:"read_permission";a:1:{s:14:"NICU_NURSE_DAY";s:2:"on";}}',
                'Status' => 'Active',
                'UserAdded' => NULL,
                'UserModified' => NULL,
                'DateAdded' => '2017-08-03 15:01:31',
                'DateModified' => '2017-08-03 15:19:36',
            ),
            2 => 
            array (
                'RoleId' => 1,
                'RoleName' => 'Admin',
                'Permissions' => 'a:2:{s:16:"write_permission";a:33:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:6:"OP_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:9:"PEDI_FORM";s:2:"on";s:8:"PEDI_DAY";s:2:"on";s:14:"PEDI_DISCHARGE";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:9:"MAS_DRUGS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:5:"USERS";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:13:"DELETE_ACCESS";s:2:"on";s:11:"SITE_CONFIG";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";}s:15:"read_permission";a:39:{s:10:"MOTHER_REG";s:2:"on";s:8:"BABY_REG";s:2:"on";s:6:"OP_REG";s:2:"on";s:8:"NEONATAL";s:2:"on";s:9:"NICU_FORM";s:2:"on";s:8:"NICU_DAY";s:2:"on";s:14:"NICU_DISCHARGE";s:2:"on";s:9:"PEDI_FORM";s:2:"on";s:8:"PEDI_DAY";s:2:"on";s:14:"PEDI_DISCHARGE";s:2:"on";s:9:"POST_FORM";s:2:"on";s:8:"POST_DAY";s:2:"on";s:14:"POST_DISCHARGE";s:2:"on";s:11:"REPORT_NICU";s:2:"on";s:9:"REPORT_OP";s:2:"on";s:11:"REPORT_PEDI";s:2:"on";s:14:"REPORT_NEWBORN";s:2:"on";s:14:"REPORT_CULTURE";s:2:"on";s:12:"REPORT_BIRTH";s:2:"on";s:9:"TEST_ECHO";s:2:"on";s:10:"TEST_ULTRA";s:2:"on";s:12:"TEST_CULTURE";s:2:"on";s:15:"MAS_ANTIBIOTICS";s:2:"on";s:17:"MAS_COMPLICATIONS";s:2:"on";s:9:"MAS_DRUGS";s:2:"on";s:13:"MAS_M_PROBLEM";s:2:"on";s:16:"MAS_B_PROCEDUURE";s:2:"on";s:13:"MAS_B_PROBLEM";s:2:"on";s:11:"MAS_VACCINE";s:2:"on";s:14:"MAS_INDICATION";s:2:"on";s:11:"MAS_DOCTORS";s:2:"on";s:17:"MAS_ADMISSIONMODE";s:2:"on";s:25:"MAS_RESPIRATORYINDICATION";s:2:"on";s:10:"CALCULATOR";s:2:"on";s:5:"USERS";s:2:"on";s:11:"USER_GROUPS";s:2:"on";s:13:"DELETE_ACCESS";s:2:"on";s:11:"SITE_CONFIG";s:2:"on";s:14:"NICU_NURSE_DAY";s:2:"on";}}',
                'Status' => 'Active',
                'UserAdded' => 0,
                'UserModified' => 0,
                'DateAdded' => '2015-07-10 12:00:32',
                'DateModified' => '2017-08-03 15:19:57',
            ),
        ));
    }
}
