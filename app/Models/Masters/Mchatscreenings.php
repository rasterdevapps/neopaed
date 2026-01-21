<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Mchatscreenings extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'm_chat_r_screenings';

    /**
     * Define the table primary key
     *
     * @var $primary key
     */
    protected $primaryKey = 'id';

    /**
     * Define the table timestamps
     *
     * @var $timestamps
     */
    public $timestamps    = false;

    /**
     * Define the table fillable columns
     *
     * @var $fillable
     */
    protected $fillable   = ['question_id', 'baby_id', 'op_id', 'answer', 'create_user_id', 'create_date_time', 'modify_user_id', 'modify_date_time', 'type', 'is_deleted', 'deleted_by', 'description', 'final_answer'];
            

}
