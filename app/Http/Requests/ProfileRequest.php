<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request 
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
		$password = $this->new_password;
		if ($password!='') {
			return [
				'name'	=> 'required|min:3',
				'new_password'	=> 'required|confirmed',
				//
			];
		} else {
			return [
				'name'	=> 'required|min:3',
			];
		}
	}
	public function messages()
	{
		return [
				'new_password.confirmed'	=> 'New Password does not match',
			];
	}
}
