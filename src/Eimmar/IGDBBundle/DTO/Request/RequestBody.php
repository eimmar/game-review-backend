<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\DTO\Request;

class RequestBody
{
    /**
     * @var array|null
     */
    private array $fields;

    /**
     * @var string|null
     */
    private string $where;

    /**
     * @var string|null
     */
    private string $sort;

    /**
     * @var string|null
     */
    private string $search;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var int
     */
    private int $offset;

    /**
     * @param array $fields
     * @param string $where
     * @param string $sort
     * @param string $search
     * @param int $limit
     * @param int $offset
     */
    public function __construct(array $fields = [], string $where = '', string $sort = '', string $search = '', int $limit = 10, int $offset = 0)
    {
        $this->fields = $fields;
        $this->where = $where;
        $this->sort = $sort;
        $this->search = $search;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getWhere(): string
    {
        return $this->where;
    }

    /**
     * @param string $where
     */
    public function setWhere(string $where): void
    {
        $this->where = $where;
    }

    /**
     * @return string|null
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     */
    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function unwrap(): string
    {
        $unwrapped = '';
        $parts = [
            'fields' => trim(implode(',', $this->fields)),
            'where' => trim($this->where),
            'sort' => trim($this->sort),
            'limit' => (string)$this->limit,
            'offset' => (string)$this->offset
        ];

        foreach ($parts as $part => $value) {
            $unwrapped .= strlen($value) > 0 ? sprintf('%s %s;', $part, $value) : '';
        }
        $unwrapped .= strlen(trim($this->search)) > 0 ? sprintf('search "%s";', trim($this->search)) : '';

        return $unwrapped;
    }
}
