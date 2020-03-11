<?php

declare(strict_types=1);


namespace App\Eimmar\GameSpotBundle\DTO\Request;

class ApiRequest
{
    /**
     * @var string
     */
    private string $format;

    /**
     * @var array|null
     */
    private ?array $fieldList;

    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * @var int|null
     */
    private ?int $offset;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var array|null
     */
    private ?array $filter;

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
