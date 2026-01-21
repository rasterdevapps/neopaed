<?php namespace App\Http\Requests\Admissions;

use App\Http\Requests\Request;

class PostdayRequest extends Request 
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
			'DayDate'			=> 'required|date',
			//'DayTime'			=> 'required',	
			'DayOfLife'			=> 'numeric',
		];
	}

}