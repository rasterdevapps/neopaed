@php
$file_name = $results['BabyName'] . '('. $results['BMrNo'] . ') -' . $results['visit_date'];
header('Content-Type: application/vnd.msword');
header('Content-Disposition: attachment; filename="'.$file_name.'.doc"');
header('Cache-Control: private, max-age=0, must-revalidate');
@endphp
<div style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 12px; line-height: 1.1;width: 100%; float: left;">
    <div style="width: 100%; float: left; margin-bottom: 30px;">
        <div class="col-xs-4">
            <img src="{!! SiteHelpers::getOpLogo($results->id) !!}" width="200" height="25">
        </div>
        <div class="col-xs-4">
            Bayley Scale
        </div>
    </div>
    <div style="width: 100%; float: left;">
        <div style="width: 50%; float: left;">
            Baby Name : B/O Meera 
        </div>
        <div style="width: 50%; float: left;">
            BUHID : SNH230133
        </div>
        <div style="width: 50%; float: left;">
            DOB : 11-04-2023
        </div>
        <div style="width: 50%; float: left;">
            Gestation : 39+4
        </div>
        <div style="width: 50%; float: left;">
            Gender : Male
        </div>
    </div>
</div>