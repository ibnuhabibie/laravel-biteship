<?php

namespace Cloudenum\Biteship;

/**
 * Location Model
 *
 * @property ?string $id
 * @property ?string $name
 * @property ?string $contact_name
 * @property ?string $contact_phone
 * @property ?string $contact_email
 * @property ?string $address
 * @property ?string $area_id
 * @property ?string $area_name
 * @property ?string $city_name
 * @property ?string $province_name
 * @property ?string $postal_code
 * @property ?float $latitude
 * @property ?float $longitude
 * @property ?string $note
 * @property ?string $type
 *
 * @see https://biteship.com/id/docs/api/locations/overview
 */
class Location extends BiteshipObject
{
    protected static string $apiUri = '/v1/locations';

    protected array $dynamicProperties = [
        'id',
        'name',
        'contact_name',
        'contact_phone',
        'contact_email',
        'address',
        'area_id',
        'area_name',
        'city_name',
        'province_name',
        'postal_code',
        'latitude',
        'longitude',
        'note',
        'type',
    ];

    /**
     * Create a new Location
     *
     * @param  array  $data  The location data
     * @return static
     *
     * @see https://biteship.com/id/docs/api/locations/create
     */
    public static function create(array $data): static
    {
        $data = \Illuminate\Support\Arr::whereNotNull($data);

        $response = Biteship::api()->post(self::$apiUri, $data);
        $responseJson = $response->json();

        return new static($responseJson ?? []);
    }

    /**
     * Find a Location by ID
     *
     * @param  string  $id  The location ID
     * @return static
     *
     * @see https://biteship.com/id/docs/api/locations/retrieve
     */
    public static function find(string $id): static
    {
        $response = Biteship::api()->get(self::$apiUri.'/'.$id);
        $responseJson = $response->json();

        return new static($responseJson);
    }

    /**
     * Get all locations
     *
     * @return \Illuminate\Support\Collection<Location>
     *
     * @see https://biteship.com/id/docs/api/locations/list
     */
    public static function all(): \Illuminate\Support\Collection
    {
        $response = Biteship::api()->get(self::$apiUri);
        $responseJson = $response->json();

        return collect($responseJson['locations'] ?? [])->map(function (array $attributes) {
            return new static($attributes);
        });
    }

    /**
     * Update a Location
     *
     * @param  Location|string  $id  The Location ID or the Location object
     * @param  array  $data  The location data to update
     *
     * @see https://biteship.com/id/docs/api/locations/update
     */
    public static function update(Location|string $id, array $data): static
    {
        $location = $id;
        if (is_string($location)) {
            $location = new static(['id' => $id]);
        }

        $data = \Illuminate\Support\Arr::whereNotNull($data);

        $response = Biteship::api()->put(self::$apiUri.'/'.$location->id, $data);
        $responseJson = $response->json();

        if ($responseJson['success'] ?? false) {
            $location->fillDynamicProperties($responseJson);
        }

        return $location;
    }

    /**
     * Delete a Location
     *
     * @param  string  $id  The location ID
     * @return bool
     *
     * @see https://biteship.com/id/docs/api/locations/delete
     */
    public static function delete(string $id): bool
    {
        $response = Biteship::api()->delete(self::$apiUri.'/'.$id);
        $responseJson = $response->json();

        return $responseJson['success'] ?? false;
    }
}