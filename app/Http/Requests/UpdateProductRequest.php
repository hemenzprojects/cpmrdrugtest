<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Product;
use App\Rules\ProductPriceLimit;

class UpdateProductRequest extends FormRequest
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
       
        $rules = [
            'name' => 'required|min:3',        
            'customer_id' => 'required',
            'product_type_id' => 'required',
            'price' => ['required','numeric',new ProductPriceLimit],
            'quantity' =>  'required|numeric', 
            'dosage' => 'required|min:3',
            // 'mfg_date' => 'required',
            // 'exp_date' => 'required',
            'indication' => 'required|min:3',
            ];

        return $rules;
        
    }
}
