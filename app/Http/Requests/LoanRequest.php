<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'date_given' => 'required|date',
            'guarantors' => 'required',
        ];
    }

    public function messages(){
        return [
            'member_id.required' => 'Please Choose a member',
            'member_id.numeric' => 'Please Choose a valid member',
            'amount.required' => 'Please enter the amount of loan to apply for',
            'amount.numeric' => 'Please enter a valid amount',
            'date_given.required' => 'Please Choose the date the loan was given',
            'date_given.date' => 'Please Choose/Enter a valid date',
            'guarantors.required' => 'Please Choose Guarantors',
        ];
    }
}
