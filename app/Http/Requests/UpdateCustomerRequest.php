<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Customer;
class UpdateCustomerRequest extends FormRequest
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
        $old_customer = Customer::where('id', $this->id)->first();
        return [
        'email' => 'required|email|max:128|unique:users',       
        ];

        if ($this->get('email') == $old_customer->email) {
            $rulesHere['email'] = 'required';
        }
    }
}
