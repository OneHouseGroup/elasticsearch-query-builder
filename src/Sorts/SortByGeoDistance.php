<?php

namespace Spatie\ElasticsearchQueryBuilder\Sorts;

class SortByGeoDistance
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    protected bool $ignoreUnmapped = true;

    public static function create(string $field, float $longitude, float $latitude, string $order = self::ASC): static
    {
        return new self($field, $longitude, $latitude, $order);
    }

    public function __construct(
        protected string $field,
        protected float $longitude,
        protected float $latitude,
        protected string $order = self::ASC
    ) {
        
    }

    public function ignoreUnmapped(bool $ignoreUnmapped): static
    {
        $this->ignoreUnmapped = $ignoreUnmapped;

        return $this;
    }

    public function toArray(): array
    {
        $payload = [
            'order' => $this->order,
            'ignore_unmapped' => $this->ignoreUnmapped,
            'unit' => 'km',
            'mode' => 'min',
            'distance_type' => 'arc',
            $this->field => [
                "lat" => $this->latitude,
                "lon" => $this->longitude,
            ],
        ];

        return [
            '_geo_distance' => $payload,
        ];
    }
}
