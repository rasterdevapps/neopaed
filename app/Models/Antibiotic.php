<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antibiotic extends Model
{
    protected $table = 'antibiotics';
    protected $primaryKey = 'DayId';
    public $timestamps = false;
    protected $fillable = ['DayId', 'BabyId', 'Antibiotic', 'Day','AdmissionId'];

}
