<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MicroTestCreateLoadRule;
use App\Rules\MicroTestCreateEfficacyRule;
use App\Rules\MicroTestCreateCountRule;




class MicroTestCreateRequest extends FormRequest
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
            'micro_product_id' => 'required|numeric',
            'test_conducted_id' =>['required','numeric',new MicroTestCreateLoadRule],
            'microbialcount' => ['numeric',new MicroTestCreateCountRule],
            'efficacyanalyses' => ['numeric',new MicroTestCreateEfficacyRule], 
           
        ];
         
        if ($this->get('efficacyanalyses') == 3) {
            unset($rule['micro_product_id']);
            unset($rule['test_conducted_id']);

        }
        // if (($this->get('microbialcount') == 3) && ($this->get('loadanalyses') == 1)) {
        //     $rule['doublecheck'];
        // }
      
        return $rule;
    }
}
