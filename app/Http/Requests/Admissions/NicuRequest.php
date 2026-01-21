<?php namespace App\Http\Requests\Admissions;

use App\Http\Requests\Request;

class NicuRequest extends Request 
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
			//'AdmissionDate'			=> 'required|date',
			'AdmissionTime'			=> 'required',	
			'AdmissionWt'			=> 'numeric',
			'AgeOnAdmission'		=> 'numeric',
			//'CorrectedGestation'	=> 'numeric|min:23|max:44',
			'Length'				=> 'numeric',
			'OFC'					=> 'numeric',
			'DischargeDate'			=> 'date',
			'DischargeWeight'		=> 'numeric',
			'air_flow'              => 'numeric',
			'oxgen_flow'            => 'numeric',
		];
	}

}
