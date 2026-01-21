<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request 
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
		$id = $this->id;

		if (is_numeric($id)) {
			$field_validation = [
				'name'	=> 'required|min:3',
				'email'	=> 'required|unique:users,email,'.$id.'|min:3',
				'password'	=> '|confirmed',
				'RoleId'	=> '|numeric',
				// 'isMaster'	=> 'required'
				//
			];

			if (isset($this->job_title)) {
				$field_validation['job_title'] = 'required';
			}

			if (isset($this->Qualification)) {
				$field_validation['Qualification'] = 'required';
			}
			
			if (isset($this->type)) {
				$field_validation['type'] = 'required';
			}
			
			if (isset($this->register_no)) {
				$field_validation['register_no'] = 'required';
			}

			return $field_validation;
		} else {
			$field_validation =  [
				'name'	=> 'required|min:3',
				'email'	=> 'required|unique:users',
				'password'	=> 'required|min:3|confirmed',
				'RoleId'	=> 'required|numeric',
				// 'isMaster'	=> 'required'
				//
			];

			if (isset($this->job_title)) {
				$field_validation['job_title'] = 'required';
			}

			if (isset($this->Qualification)) {
				$field_validation['Qualification'] = 'required';
			}
			
			if (isset($this->type)) {
				$field_validation['type'] = 'required';
			}
			
			if (isset($this->register_no)) {
				$field_validation['register_no'] = 'required';
			}

			return $field_validation;

		}
	}
	public function messages()
	{
		return [
				'RoleId.required'	=> 'The usergroup field is required.',
				'RoleId.numeric'	=> 'The usergroup field should be numeric.',
			];
	}
}
