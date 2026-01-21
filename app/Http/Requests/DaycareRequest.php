<?php namespace App\Http\Requests;

class DaycareRequest extends Request
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
            'BabyName' => 'required|min:3',
           // 'CGA' => 'numeric|min:23|max:44',
            'DOB' => 'date',
        ];
    }

}