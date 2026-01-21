<?php namespace App\Http\Requests\Tests;

use App\Http\Requests\Request;

class CranialRequest extends Request 
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
			'TestDate'			=> 'required|date',
			'Age'				=> 'required',	
			'Indication'		=> 'required',
			'Impression'		=> 'required',
			'UsgRt'				=> 'required',
			'UsgLt'				=> 'required',
			'UsgGeneral'		=> 'required',						
		];
	}

}