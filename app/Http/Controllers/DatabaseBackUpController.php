<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zip;

class DatabaseBackUpController extends Controller
{
    public function backup($backup) {

    	if(!is_dir($backup['backup_path'].'/backup')) {
            mkdir($backup['backup_path'].'/backup', 0777, true);
        }

        $db_backup_query  = 'PGPASSWORD="'.$backup['db_password'].'" pg_dump --host '.$backup['db_host_name'].' --port 5432 --username '.$backup['db_user_name'].' --format plain --file '.$backup['path_to_db_backup'].' '.$backup['db_name'].'';
        $executing_query  = exec($db_backup_query);
        $data             = array();

        if ($backup['is_forward']) {

            $zip = Zip::create($backup['path_to_attachment']);
            $zip->add($backup['path_to_db_backup']);
            $zip->close();
            $pathToAttachment = $backup['path_to_attachment'];

            \Mail::send('settings.email.backup', $data, function ($message) use ($pathToAttachment) {
                        $message->from('neopaed@raster.in');
                        $message->subject('Backup Query');
                        $message->to('manikandan.m@raster.in');
                        $message->cc('aisvaryalakshmi.s@raster.in');
                        $message->attach($pathToAttachment,['as'=>'backup.zip','mime' => 'application/zip',]);
            });
        }

        if ($backup['is_remove']) {
            \File::delete($backup['path_to_db_backup']);
        }

        echo "Mail send successfully !";

    }
}
