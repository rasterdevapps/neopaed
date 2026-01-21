<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class MotherRequest extends Request 
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
			
			// 'MotherName'		=> 'required|min:3',
			// 'Mobile'			=> 'numeric',
			// 'PartnerContact'	=> 'numeric',
			// 'Email'				=> 'email',
			// 'MotherDOB'			=> 'date',
			// 'PartnerDOB'		=> 'date'
		];
	}
	public function messages()
	{
		return [
			// 'MotherName.required'=>'Please enter first name !'
		];
	}

}
