<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class NestedQuery implements Query
{
    protected string $path;
    protected bool $ignoreUnmapped = true;

    protected Query $query;

    public static function create(string $path, Query $query): self
    {
        return new self($path, $query);
    }

    public function __construct(
        string $path,
        Query $query
    ) {
        $this->path = $path;
        $this->query = $query;
    }

    public function ignoreUnmapped(bool $ignoreUnmapped): static
    {
        $this->ignoreUnmapped = $ignoreUnmapped;

        return $this;
    }

    public function getFieldName(): string {
        return false;
    }

    public function toArray(): array
    {
        return [
            'nested' => [
                'path' => $this->path,
                'query' => $this->query->toArray(),
                'ignore_unmapped' => $this->ignoreUnmapped,
            ],
        ];
    }
}
