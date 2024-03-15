<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CountPeopleAndDishRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dishs = request()->input('dishs');

        $countName = 0;
        foreach ($dishs as $item) {
            $countName += $item['number_dish'];
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Số lượng món ăn phải lớn hơn số lượng người.';
    }
}
