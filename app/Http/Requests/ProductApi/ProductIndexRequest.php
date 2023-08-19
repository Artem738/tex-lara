<?php

namespace App\Http\Requests\ProductApi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductIndexRequest extends FormRequest
{
    public function rules()
    {
        //$currentYear = Date::now()->year;
        return [
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'fabric'  => ['nullable', 'integer', 'exists:fabrics,id'],
            'tone'  => ['nullable', 'integer', 'exists:tones,id'],
            'pattern'  => ['nullable', 'integer', 'exists:patterns,id'],
            'country_id'  => ['nullable', 'integer', 'exists:countries,id'],
            'purpose'  => ['nullable', 'integer', 'exists:purpose,id'],
            'prod_status'  => ['nullable','string', 'exists:purpose,id'], //ENUM
            'lastId' => ['nullable', 'integer', 'exists:products,id'],
//            minPrice
//            maxPrice

//            'startDate' => ['required', 'date', 'before:endDate'],
//            'endDate' => ['required', 'date', 'after:startDate'],
//            'year' => ['nullable', 'integer', 'min:1970', 'max:' . $currentYear],
//            'lang' => ['nullable', 'string', Rule::in(array_column(LangEnum::cases(), 'value'))],
//            'lastId' => ['nullable', 'integer', 'exists:books,id'],
//            'limit' => ['nullable', 'integer', Rule::in(array_column(LimitEnum::cases(), 'value'))],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }

}
