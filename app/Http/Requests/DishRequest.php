<?php

namespace App\Http\Requests;

use App\Rules\CountPeopleAndDishRule;
use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
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
        return [
            'meal' => ['required', 'string', 'max:255'],
            'count_people' => ['required', 'numeric', 'min:1', 'max:10', new CountPeopleAndDishRule()],
            'restaurant' => ['required', 'string', 'max:255'],
            'dishs' => ['required', 'array'],
            'dishs.*.name' => ['required', 'string', 'max:255'],
            'dishs.*.number_dish' => ['required', 'numeric', 'min:1', 'max:10'],
        ];
    }
}
