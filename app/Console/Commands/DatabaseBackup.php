<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DatabaseBackUpController;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dbbackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Backup';

    /**
     * The need mail send.
     *
     * @var boolegn
     */
    protected $is_forward = true;

    /**
     * The need mail send.
     *
     * @var boolean
     */
    protected $is_remove = true;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->db_host_name       = env('DB_HOST');
        $this->db_name            = env('DB_DATABASE');
        $this->db_user_name       = env('DB_USERNAME');
        $this->db_password        = env('DB_PASSWORD');
        $this->backup_path        = public_path();
        $this->path_to_db_backup  = $this->backup_path.'/backup/'.$this->db_name.'_'.date('Y-m-d').'.psql';
        $this->path_to_attachment = $this->backup_path.'/backup/'.date('Y-m-d').'.zip';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbBackUp = new DatabaseBackUpController();

        $dbBackUp->backup([
            'backup_path'         => $this->backup_path,
            'db_password'         => $this->db_password,
            'db_host_name'        => $this->db_host_name,
            'db_user_name'        => $this->db_user_name,
            'path_to_db_backup'   => $this->path_to_db_backup,
            'db_name'             => $this->db_name,
            'is_forward'          => $this->is_forward,
            'path_to_attachment'  => $this->path_to_attachment,
            'is_remove'           => $this->is_remove
        ]); 

    }
}
