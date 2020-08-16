<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductDistributionRequest extends FormRequest
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
        $rule = [
            'product_id' => 'required|unique:product_depts', 
            'microquantity' => 'numeric',      
            'pharmquantity' => 'numeric',  
            'phytoquantity' => 'numeric',
       
        ];
       
        if ($this->get('microbiology') == 1) {
            $rule['microquantity'];
        }else {
            unset($rule['microquantity']);
        }

        if ($this->get('pharmacology') == 2) {
            $rule['pharmquantity'];
        } else {
            unset($rule['pharmquantity']);
        }

        if ($this->get('phytochemistry') == 3) {
            $rule['phytoquantity'];
        } else {
            unset($rule['phytoquantity']);
        }
      
        return $rule;
    }
}
