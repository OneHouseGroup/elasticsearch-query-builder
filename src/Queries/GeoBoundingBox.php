<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class GeoBoundingBox implements Query
{
    public static function create(
        string $field,
        float $from_longitude,
        float $from_latitude,
        float $to_longitude,
        float $to_latitude
    ): self {
        return new self($field, $from_longitude, $from_latitude, $to_longitude, $to_latitude);
    }

    public function __construct(
        protected string $field,
        protected float $from_longitude,
        protected float $from_latitude,
        protected float $to_longitude,
        protected float $to_latitude
    ) {
    }

    public function getFieldName(): string
    {
        return $this->field;
    }

    public function toArray(): array
    {
        return [
            'geo_bounding_box' => [

                $this->field => [

                    "top_left" => [
                        "lat" => $this->from_latitude,
                        "lon" => $this->from_longitude,
                    ],
                    "bottom_right" => [
                        "lat" => $this->to_latitude,
                        "lon" => $this->to_longitude,
                    ],
                ],
            ],
        ];

    }
}
