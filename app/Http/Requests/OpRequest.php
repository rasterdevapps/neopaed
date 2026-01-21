<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class OpRequest extends Request 
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
			//'MotherName'		=> 'required|min:3',
			// 'Mobile'			=> 'numeric',
// 			'PartnerContact'	=> 'numeric',
// 			'Email'				=> 'email',
// 			'MotherDOB'			=> 'date',
// 			'PartnerDOB'		=> 'date',	
			'BabyName'			=> 'required|min:3',
			// 'BirthWeight'		=> 'numeric',
// 			'DOB'				=> 'date',
// 			'CurrentLength'		=> 'numeric|min:30|max:60',
// 			'CurrentWt'			=> 'numeric',
// 			'Gestation'			=> 'numeric',
// 			'DayOfLife'			=> 'numeric',
			// 'OpDate'			=> 'date|required',
//             'Current_OFC'		=> 'numeric|min:20|max:60',
// 			'Gestation'		    => 'numeric|min:23|max:44',
// 			'HeadCircumference'	=> 'required|numeric|between:0,99.9'
		];
	}

}