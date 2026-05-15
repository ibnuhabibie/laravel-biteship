<?php

namespace Cloudenum\Biteship;

use Illuminate\Support\Arr;

/**
 * @property array|null $origin
 * @property array|null $destination
 * @property array|null $pricing
 */
class CourierPricing extends BiteshipObject
{
    protected static string $apiUri = '/v1/rates/couriers';

    protected array $dynamicProperties = [
        'origin',
        'destination',
        'pricing',
    ];

    /**
     * Get the delivery prices for couriers
     *
     *
     * @see https://biteship.com/id/docs/api/rates/retrieve
     */
    public static function Rates(array $data): CourierPricing
    {
        $data = Arr::whereNotNull($data);

        $response = Biteship::api()->post(self::$apiUri, $data);
        $responseJson = $response->json();

        return new static($responseJson);
    }
}
