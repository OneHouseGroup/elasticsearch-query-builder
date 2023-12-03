<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class MatchAllQuery implements Query
{
    public function toArray(): array
    {
        return [
            'match_all' => (object) [],
        ];
    }
}
