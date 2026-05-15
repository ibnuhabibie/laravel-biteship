<?php

namespace Cloudenum\Biteship;

use Cloudenum\Biteship\Exceptions\InvalidArgumentException;

class Biteship
{
    /**
     * Get the Biteship API instance
     *
     * @param  array  $config  The API configuration
     *
     * @throws InvalidArgumentException
     */
    public static function api(array $config = []): BiteshipApi
    {
        $config = array_merge([
            'api_key' => config('biteship.api_key'),
            'base_url' => config('biteship.base_url'),
        ], $config);

        return app(BiteshipApi::class, ['config' => $config]);
    }
}
