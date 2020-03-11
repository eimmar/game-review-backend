<?php

declare(strict_types=1);


namespace App\Service\GameSpot\Request;

class ApiRequest
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var array|null
     */
    private $fieldList;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var string|null
     */
    private $sort;

    /**
     * @var array|null
     */
    private $filter;

    /**
     * @param string $format
     * @param array|null $fieldList
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $sort
     * @param array|null $filter
     */
    public function __construct(
        string $format,
        ?array $filter = null,
        ?array $fieldList = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $sort = null
    ) {
        $this->format = $format;
        $this->fieldList = $fieldList;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->filter = $filter;
    }

    /**
     * @return array
     */
    public function unwrap(): array
    {
        $filter = [];

        foreach ((array)$this->filter as $field => $value) {
            $filter[] = $field . ':' . $value;
        }

        return array_filter([
            'format' => $this->format,
            'field_list' => implode(',', (array)$this->fieldList),
            'limit' => $this->limit,
            'offset' => $this->offset,
            'sort' => $this->sort,
            'filter' => $filter
        ]);
    }
}
