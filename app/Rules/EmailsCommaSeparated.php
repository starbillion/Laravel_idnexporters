<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailsCommaSeparated implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = explode(',', $value);

        array_walk($value, function (&$v) {
            $v = trim($v);
        });

        $rules = [
            'email' => 'required|email',
        ];
        if ($value) {
            foreach ($value as $email) {
                $data = [
                    'email' => $email,
                ];
                $validator = \Validator::make($data, $rules);
                if ($validator->fails()) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must have valid email addresses.';
    }
}
