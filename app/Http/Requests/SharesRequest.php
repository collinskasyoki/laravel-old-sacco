<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SharesRequest extends FormRequest
{
    /**
     * Determine if the member is authorized to make this request.
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
            'member_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'date_received' => 'required|date',
        ];
    }

    public function messages(){
        return [
            'member_id.required' => 'Please Select a Valid Member',
            'member_id.numeric' => 'Please Select a Valid member',
            'amount.required' => 'Enter a valid amount',
            'amount.numeric' => 'Enter a valid amount',
            'date_received.required' => 'Please select a date',
            'date_received.date' => 'Select Please A valid date',
        ];
    }
}
