<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        $this->session()->flash('message_title', 'error');
        $this->session()->flash('message', 'Please check error(s) indicated and retry.');
        
        return [
            'first_name' => 'required|min:3|Alpha', 
            'last_name' => 'required|min:3|Alpha', 
            'street_address' => 'required', 
            'email' => 'required|email|max:128|unique:users', 
            'tell' => 'required|numeric', 
           
        ];
    }
}
