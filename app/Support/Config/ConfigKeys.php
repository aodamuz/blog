<?php

namespace App\Support\Config;

class ConfigKeys
{
    const AUTO_LOGIN = 'auth.automatic_login_after_registration';

    public static function all()
    {
        return [
            self::AUTO_LOGIN => __('Automatic login after registration'),
        ];
    }
}
