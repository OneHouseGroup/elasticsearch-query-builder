<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

interface Query
{
    public function toArray(): array;

    public function getFieldName(): string;
}
