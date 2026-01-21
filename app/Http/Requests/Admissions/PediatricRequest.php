<?php namespace App\Http\Requests\Admissions;

use App\Http\Requests\Request;

class PediatricRequest extends Request 
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
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
		return [
			'AdmissionDate'			=> 'required|date',
			// 'AdmissionTime'			=> 'required',	
			'AdmissionHours'		=> 'required',	
			'AdmissionMins'		    => 'required',	
			'AdmissionSession'		=> 'required',	
			'AdmissionWt'			=> 'numeric',
			'AgeOnAdmission'		=> 'numeric',
			'CurrentWt'				=> 'numeric',
			'CurrentLength'			=> 'numeric',
			'CurrentOFC'			=> 'numeric',
			'DischargeDate'			=> 'date',
			'DischargeWeight'		=> 'numeric'
		];
	}

}
