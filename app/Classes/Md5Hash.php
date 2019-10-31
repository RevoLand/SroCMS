<?php

namespace App\Classes;

use Illuminate\Contracts\Hashing\Hasher;

class Md5Hash implements Hasher
{
    /**
     * Get information about the given hashed value.
     *
     * @param string $hashedValue
     *
     * @return array
     */
    public function info($hashedValue): array
    {
        return password_get_info($hashedValue);
    }

    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     *
     * @return string
     */
    public function make($value, array $options = []): string
    {
        return md5($value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        return (strlen($hashedValue) === 0) ? false : $hashedValue === md5($value);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return false;
    }
}
