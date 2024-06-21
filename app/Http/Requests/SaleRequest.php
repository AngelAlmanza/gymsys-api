<?php

namespace App\Http\Requests;

use App\Rules\HasSufficientStock;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'member_id' => 'required|exists:members,id',
            'date' => 'required|date',
            'concepts' => 'required|array',
            'concepts.*.product_id' => 'required|exists:products,id',
            'concepts.*.quantity' => 'required|integer|min:1',
        ];

        foreach ($this->input('concepts', []) as $key => $concept) {
            $rules["concepts.{$key}.product_id"] = new HasSufficientStock($concept['product_id'], $concept['quantity']);
        }

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
