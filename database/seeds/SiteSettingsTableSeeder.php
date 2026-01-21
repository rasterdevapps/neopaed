<?php

use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('site_settings')->delete();

        \DB::table('site_settings')->insert(array (           
            0 => 
            array (
                'SiteId' => 1,
                'LogoImage' => '',
                'PrintLogo' => 'header.png',
                'SiteName' => '',
                'BMRSettings' => 'a:4:{i:1;s:4:"1301";i:2;s:2:"MM";i:3;s:2:"YY";i:4;s:1:"6";}',
                'MMRSettings' => 'a:4:{i:1;s:4:"1001";i:2;s:2:"YY";i:3;s:2:"MM";i:4;s:1:"4";}',
                'DateModified' => date('Y-m-d h:i:s'),
                'OverwriteBabyMR' => 1,
                'OverwriteMotherMR' => 0,
                'dSummaryedit' => 1,
                'mirthIntegration' => 2,
                'discharge_report_left' => '<p><span style="font-size:9px"><strong>DR D.V.SURESH </strong></span><span style="font-size:8px"><strong>DCH ,DNB(PED), MNAMS</strong></span></p><p><span style="font-size:9px"><em>(CONSULTANT PEDIATRICIAN &amp; NEONATAL INTENSIVIST)</em></span></p>',
                'discharge_report_right' => '<div><span style="font-size:9px"><strong>DR S.RAMAKRISHNAN </strong></span><span style="font-size:8px">MRCPCH (UK), MRCP (IRE), DCH(UK), DIP PN (LON)</span></div><div><span style="font-size:9px"><em>CONSULTANT NEONATAL PAEDIATRICIAN</em></span></div><div><span style="font-size:9px"><strong><u>SPECIAL INTERESTS:</u></strong></span></div><div><span style="font-size:9px"><em>NEONATAL FUNCTIONAL ECHOCARDIOGRAPHY</em></span></div><div><span style="font-size:9px"><em>PAEDIATRIC NUTRITION </em></span></div><div><span style="font-size:9px"><em>NEURODEVELOPMENTAL SCREENING</em></span></div>',
                'discharge_instraction' => '<p>&nbsp;Parents were given advice on the following: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><ol><li>&nbsp; General baby care instructions.</li><li>&nbsp; Paladai feeding, breast feeding and milk preparation methods.</li><li>&nbsp; Breast milk storage instructions.</li><li>&nbsp; Withdrawing and administering medications.</li><li>&nbsp; Emergency baby care instructions provided.</li><li>&nbsp; Immunisations to be administered as per current IAP schedule.</li><li>&nbsp; Contact numbers in case of emergency has been provided.</li></ol>',
                'discharge_summary_footer' => '',
                'pagenation_limit_options' => '[""]',
                'hospital_contact' => '0422-4201000',
                'hospital_name' => 'SKS HOSPITALS PVT LTD',
                'PrintLogoOption' => '',
                'licence_key' => '',
                'header_required' => 1,
                'nurse_entry_start' => '',
                'api_key' => 'eyJpdiI6ImhmcGxRVFJEcGdUU3F6VVJWS2c0emc9PSIsInZhbHVlIjoiOU1zdmpvelFGVTk2OVBvYWZ1alBlZz09IiwibWFjIjoiMGJhMTVjNjhkZWQ4NzZiOTZmYzI2NzM3ZGYzNTgyNjc5NzIyYzZjMDc1NTBkZDA2MGIwNGI5MjI5Yzg0MTYxMCJ9',
                'api_user_name' => 'admin',
                'api_password' => 'eyJpdiI6InNaUW9cLzNIUG9pU1cxdlVuTnRaNDJnPT0iLCJ2YWx1ZSI6ImNRVm1KeHpuMnJNWVF4WmRET1psaGc9PSIsIm1hYyI6ImVhMGRhYzc3ZDFhMWJkMjk0MmFlYzI3ZWE2YzQ0NmIxZWQxNWZhZWZkZGJjOGEwMTVkYzkzM2VhOGNjYzA5ZGQifQ==',
                'custom_toastr' => '{"debug": true, "timeOut": "5000", "hideEasing": "linear", "hideMethod": "fadeOut", "showEasing": "swing", "showMethod": "fadeIn", "closeButton": true, "newestOnTop": true, "progressBar": true, "hideDuration": "1000", "showDuration": "300", "positionClass": "toast-top-right", "toastTypeGroup": "info", "extendedTimeOut": "1000", "preventDuplicates": true}',
            )
        ));
    }
}
