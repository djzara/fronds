<?php

if (!function_exists('user_verify_token')) {

    /**
     * Create a token that keeps the username and ipaddress secret
     * so that it can be used for verification purposes.
     * @param string $username
     * @param bool $isValid
     * @return string
     */
    function user_verify_token(string $username, bool $isValid): string
    {
        $params = [
            'username' => $username,
            'is_valid' => $isValid,
            'ip' => request()->ip()
        ];

        return Crypt::encrypt($params);
    }
}
