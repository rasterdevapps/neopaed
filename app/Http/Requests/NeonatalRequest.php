<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class NeonatalRequest extends Request 
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public $dflash=['Complication'];
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$this->setFlash();
		return [
			// 'MotherName'		=> 'required|min:3',
			// 'Mobile'			=> 'numeric',
			// 'PartnerContact'	=> 'numeric',
			// 'Email'				=> 'email',
			// 'MotherDOB'			=> 'date',
			// 'PartnerDOB'		=> 'date',	
			// 'BabyName'			=> 'required|min:3',
			// 'BirthWeight'		=> 'numeric',
			// 'DOB'				=> 'date',
			// 'Length'			=> 'numeric',
			// 'OFC'				=> 'numeric|between:00.0,99.9',
			// //'Gestation'			=> 'numeric|min:23|max:44',
			// 'DayOfLife'			=> 'numeric',
			// 'TestDate'			=> 'date|required',
			// 'DateOfDischarge'	=> 'date',
			// 'DischargeWeight'	=> 'numeric',
			// 'duration_in_weeks'	=> 'numeric'
		];
	}
	protected function setFlash()
	{


		//return $this->flashExcept = array_merge($this->flashExcept,$this->dflash);
		
	}


}