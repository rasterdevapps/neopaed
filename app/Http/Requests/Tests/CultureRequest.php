<?php namespace App\Http\Requests\Tests;

use App\Http\Requests\Request;

class CultureRequest extends Request 
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
			'EntryDate'			=> 'required|date',
			'CollectionDate'	=> 'required|date',	
			'DayOfLife'			=> 'required|numeric',
		];
	}

}
