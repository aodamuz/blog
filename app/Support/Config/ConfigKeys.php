<?php

namespace App\Support\Config;

class ConfigKeys
{
    const AUTO_LOGIN = 'auth.automatic_login_after_registration';
    const CODE_BLOCK_IN_EDITOR_ENABLED = 'admin.posts.editor.enable_code';

    public static function all()
    {
        return [
            self::AUTO_LOGIN => __('Automatic login after registration'),
            self::CODE_BLOCK_IN_EDITOR_ENABLED => __('Code block in editor enabled'),
        ];
    }
}
