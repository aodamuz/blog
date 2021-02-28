<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostStatusRule implements Rule
{
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        return $this->user->hasPermission('post-manager');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __(
            'You do not have permission to assign the :attribute of this post.'
        );
    }
}
