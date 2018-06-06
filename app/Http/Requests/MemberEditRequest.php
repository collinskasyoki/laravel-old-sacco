<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberEditRequest extends FormRequest
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
            'name'=> 'required|string|max:500',
            'id_no'=> 'required|numeric|exists:members',
            'next_kin_name'=> 'required|string|max:500',
            'next_kin_phone'=>'required|numeric',
            'next_kin_id'=>'required|numeric',
            //'email'=>'required|email',
            'gender'=>'required|string',
            'phone'=> 'required|numeric',
            'registered_date' => 'required|date',
            'registration_fee' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Please Enter the Name.',
            'name.string' =>'Please enter a valid name.',
            'name.max' =>'Name should be less than 500 characters.',
            'id_no.required' => 'Please Enter the Id No',
            'id_no.numeric' => 'Please enter a valid ID Number',
            'id_no.exists' => 'It seems that the user you are editing can\'t be found',
            'next_kin_name.required' => 'Please enter a valid Next of Kin name',
            'next_kin_name.string' => 'Please enter a valid Next of Kin name',
            'next_kin_name.max' => 'Please enter a valid Next of Kin name',
            'next_kin_phone.required'=> 'Please enter  a valid Next of Kin phone number',
            'next_kin_phone.numeric'=> 'Please enter  a valid Next of Kin phone number',
            'next_kin_id.required'=>'Please enter a valid Next of Kin id number',
            'next_kin_id.numeric'=>'Please enter a valid Next of Kin id number',
            //'email.required' => 'Please Enter an Email Address',
            //'email.email' => 'Please Enter a valid Email Address',
            'gender.required' => 'Please Select a gender',
            'phone.numeric' => 'Please enter a Valid Phone number',
            'phone.required' => 'Please enter a Phone number',
            'registered_date.required' => 'Please Choose/Enter a Date',
            'registered_date.date' => 'Please Enter a Valid Date',
            'registration_fee.required' => 'Please enter an amount in registration fee',
            'registration_fee.number' => 'Please Enter a valid registration fee',
        ];
    }
}
