<?php

namespace Spatie\ElasticsearchQueryBuilder;

use Spatie\ElasticsearchQueryBuilder\Aggregations\Aggregation;

class AggregationCollection
{
    protected array $aggregations;
    protected bool $global = false;

    public function __construct(Aggregation ...$aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function add(Aggregation $aggregation): self
    {
        $this->aggregations[] = $aggregation;

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->aggregations);
    }

    /**
     * Set aggregations global
     * 
     */
    public function setGlobal() 
    {
        $this->global = true;

		return $this;
    }

    public function toArray(): array
    {
        $aggregations = [];

        foreach ($this->aggregations as $aggregation) {
            $aggregations[$aggregation->getName()] = $aggregation->toArray();
        }

        if ($this->global) {

			$global_aggregations['global_aggs_wrapper'] = [
				'global' => (object) [],
				'aggs' => $aggregations
			];

			return $global_aggregations;
		}

        return $aggregations;
    }
}
