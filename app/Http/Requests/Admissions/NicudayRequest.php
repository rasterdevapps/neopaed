<?php namespace App\Http\Requests\Admissions;

use App\Http\Requests\Request;

class NicudayRequest extends Request 
{

	/**
     * The input keys to extend the dontflash array  variable. 
     *
     * @var array
     */
    //protected $dFlash = ['A_Antibiotic'];

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
        //$this->setFlash();
		return [
			'DayDate'			=> 'required|date',
			'DayTime'			=> 'required',	
			'CurrentWt'			=> 'numeric',
			'DayOfLife'			=> 'numeric',
			'PreviousWt'		=> 'numeric',
			'pvc_number'        => 'numeric',
		];
	}

	// protected function setFlash(){
	// 	return $this->dontFlash = array_merge($this->dontFlash,$this->dFlash); 
	// }



}