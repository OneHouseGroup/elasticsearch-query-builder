<?php

namespace Spatie\ElasticsearchQueryBuilder;

class SortCollection
{
    protected array $sorts;

    public function __construct(mixed ...$sorts)
    {
        $this->sorts = $sorts;
    }

    public function add(mixed $sort): self
    {
        $this->sorts[] = $sort;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->sorts);
    }

    public function toArray(): array
    {
        $sorts = [];

        foreach ($this->sorts as $sort) {
            $sorts[] = $sort->toArray();
        }

        return $sorts;
    }
}
