<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Console\Command;
use Zip;


class MachineDataBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:machinebackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The backup path.
     *
     * @var string
     */
    protected $backup_path;

     /**
     * The table name .
     *
     * @var string
     */
    protected $interface_table_name = 'public.interface_machine';

     /**
     * The table name .
     *
     * @var string
     */
    protected $fhir_table = 'public.fihr_formated_values';
    
    /**
     * The host name name .
     *
     * @var string
     */
    protected $db_host_name;


    /**
     * The database name.
     *
     * @var string
     */
    protected $db_name;

    /**
     * The database user name .
     *
     * @var string
     */
    protected $db_user_name;

    /**
     * The database password.
     *
     * @var string
     */
    protected $db_password;

    /**
     * The psql file.
     *
     * @var string
     */
    protected $path_to_file;

    /**
     * The zip file .
     *
     * @var string
     */
    protected $path_to_attachment;

    /**
     * The need mail send.
     *
     * @var boolegn
     */
    protected $is_forward = true;

    /**
     * The need mail send.
     *
     * @var boolegn
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

        $this->db_host_name = env('DB_HOST');
        $this->db_name      = env('DB_DATABASE');
        $this->db_user_name = env('DB_USERNAME');
        $this->db_password  = env('DB_PASSWORD');
        $this->backup_path  = public_path();
        $this->path_to_file_interface = $this->backup_path.'/machine_data/interface_'.time().'.psql';
        $this->path_to_file_fhir = $this->backup_path.'/machine_data/fhir_'.time().'.psql';
        $this->path_to_attachment = $this->backup_path.'/machine_data/'.time().'.zip';

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         if (!is_dir($this->backup_path.'/machine_data')) {
            \File::makeDirectory($this->backup_path.'/machine_data', 0777, true, true); 
         }
        
        $permission = 'sudo chmod 777 -R '.$this->backup_path.'/machine_data';
        $executing_query  = exec($permission); 


        $interface_machine_query  = 'PGPASSWORD="'.$this->db_password.'" pg_dump --host '.$this->db_host_name.' --port 5432 --username '.$this->db_user_name.' --format plain  --file '.$this->path_to_file_interface.' --table '.$this->interface_table_name.' '.$this->db_name.'';
        $executing_query  = exec($interface_machine_query); 

        $fhir_query = 'PGPASSWORD="'.$this->db_password.'" pg_dump --host '.$this->db_host_name.' --port 5432 --username '.$this->db_user_name.' --format plain  --file '.$this->path_to_file_fhir.' --table '.$this->fhir_table.' '.$this->db_name.'';
        $executing_query  = exec($fhir_query); 
        $data             = array();


        if (Schema::hasTable('interface_machine')) {

            \DB::statement('DROP TABLE IF EXISTS "interface_machine";');
        }

        Schema::create('interface_machine', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->jsonb('received')->nullable();
            $table->time('received_time')->nullable();
            $table->boolean('is_parsed')->default('false');
            $table->string('received_ip')->nullable();
            $table->date('received_date')->nullable();
            $table->date('received_datetime')->nullable();
        });

            $db_statement  = 'ALTER TABLE "interface_machine"';
            $db_statement .= 'ALTER "received_datetime" TYPE timestamp,';
            $db_statement .= 'ALTER "received_datetime" SET DEFAULT now(),';
            $db_statement .= 'ALTER "received_datetime" DROP NOT NULL;';
            \DB::statement($db_statement);

        if (Schema::hasTable('fihr_formated_values')) {

            Schema::drop('fihr_formated_values');
        }

        Schema::create('fihr_formated_values', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->text('gender')->nullable();
            $table->text('birthdate')->nullable();
            $table->text('mrn')->nullable();
            $table->text('visit_type')->nullable();

            $table->text('date')->nullable();
            $table->text('ip_number')->nullable();
            $table->text('ward')->nullable();
            $table->text('room')->nullable();
            $table->text('bed')->nullable();
            $table->text('model')->nullable();

            $table->text('owner')->nullable();
            $table->text('patient')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('loinc_code')->nullable();
            $table->text('display')->nullable();

            $table->text('issued')->nullable();
            $table->text('status')->nullable();
            $table->text('low')->nullable();
            $table->text('first_quartile')->nullable();
            $table->text('mean')->nullable();

            $table->text('last_quartile')->nullable();
            $table->text('close')->nullable();
            $table->text('value_quality_unit')->nullable();

            $table->boolean('is_completed')->default('false');
            $table->text('asset_number')->nullable();
            $table->text('start_time')->nullable();
            $table->text('end_time')->nullable();

            $table->text('from_id')->nullable();
            $table->text('to_id')->nullable();
            $table->text('snomed_ct')->nullable();
            $table->text('snomed_code')->nullable();


        });


       
    }
}





