<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class BabyRequest extends Request 
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
			'BabyName'			=> 'required|min:3',
			'MotherId'			=> 'required',
			'BirthWeight'		=> 'numeric',
			//'Gestation'		    => 'numeric|min:23|max:44',
			'DOB'				=> 'date',
		];
	}

}
