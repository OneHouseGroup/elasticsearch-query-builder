<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

use Spatie\ElasticsearchQueryBuilder\Exceptions\BoolQueryTypeDoesNotExist;

class BoolQuery implements Query
{

    private $queries;

    public static function create(): static
    {
        return new self();
    }

    function __construct(array $queries = [] )
	{
		$this->queries = $queries;
	}

    public function add(Query $query, string $type = 'must'): static
    {
        if (! in_array($type, ['must', 'filter', 'should', 'must_not'])) {
            throw new BoolQueryTypeDoesNotExist($type);
        }

        $this->queries[] = (object) [
            'type' => $type, 
            'query' => $query
        ];

        return $this;
    }

    /**
	 * has queries?
	 * 
	 * @return bool
	 */
	public function isEmpty()
    {
        return count($this->queries) == 0;
    }

    /**
	 * Get query instance except field
	 * 
	 * @param string $fieldName
	 * @return $this
	 */
	public function getQueriesExcept(string $fieldName) 
    {
		return new self(
            array_values(
                array_filter( $this->queries, function ($queryType) use ($fieldName) {
                    if ($queryType->query->getFieldName() != $fieldName ) return true;
                })
            )
		);
    }

    public function getFieldName(): string {
        return false;
    }

    public function toArray(): array
    {
        $bool = [
            'must' => array_map(fn ($queryType) => $queryType->query->toArray(), $this->prepareQueryType('must')),
            'filter' => array_map(fn ($queryType) => $queryType->query->toArray(), $this->prepareQueryType('filter')),
            'should' => array_map(fn ($queryType) => $queryType->query->toArray(), $this->prepareQueryType('should')),
            'must_not' => array_map(fn ($queryType) => $queryType->query->toArray(), $this->prepareQueryType('must_not')),
        ];

        return [
            'bool' => array_filter($bool),
        ];
    }

    /**
	 * Prepare conditions for type
	 * 
	 * @param string $type
	 * @return array
	 */
	private function prepareQueryType( string $type) {

        return array_values(
            array_filter($this->queries, function ($queryType) use ($type) {
            if ($queryType->type == $type) return true;
            })
        );


	}
}
