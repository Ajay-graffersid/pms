<?php

namespace App\Http\Requests\Member\OfficeExpenses;

use Froiden\LaravelInstaller\Request\CoreRequest;

class StoreOfficeExpense extends CoreRequest
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
        $rules = [
            'item_name' => 'required',
            'purchase_date' => 'required',
            'price' => 'required|numeric'
        ];

        if($this->user()->cans('add_expenses')){
            $rules['employee'] = 'required';
        }

        return $rules;
    }

}
