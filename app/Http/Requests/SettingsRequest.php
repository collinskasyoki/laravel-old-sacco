<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'share_value' => 'numeric',
            'loan_interest' => 'numeric|max:100',
            'loan_duration' => 'numeric',
            'loan_borrowable' => 'numeric',
            'retention_fee' => 'numeric|max:100',
            'min_guarantors' => 'numeric',
            'name' => 'string',
        ];
    }
}
