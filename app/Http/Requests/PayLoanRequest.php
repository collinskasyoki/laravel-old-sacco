<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayLoanRequest extends FormRequest
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
        'amount' => 'required|numeric',
        'date_given' => 'required|date',
        ];
    }
}
