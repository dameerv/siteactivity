<?php

namespace App\Security;

use Exception;

class TokenGenerator
{
    /**
     * @throws Exception
     */
    public static function generate(int $length = null): string
    {
        $secret = sha1(random_bytes(100));

        return $length ? substr($secret, 0, $length) : $secret;
    }
}
