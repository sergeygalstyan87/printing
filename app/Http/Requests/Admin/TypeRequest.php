<?php

namespace App\Http\Requests\Admin;


use App\Rules\FullPaperPrice;
use Illuminate\Foundation\Http\FormRequest;


class TypeRequest extends FormRequest
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
        $validations = [
            'name' => 'required',
            'attribute_id' => 'required|numeric',
        ];

        if (isset($this->rel_attributes)) {
            $validations['related_attributes'] = 'required';
        }

        if (isset($this->full_paper) && $this->full_paper===1) {
            $validations['sizes'] = [
                'required',
                new FullPaperPrice,
            ];
        }

        $validations1 = [];

        $validations =  array_merge($validations1,$validations);

        return $validations;

    }
}
