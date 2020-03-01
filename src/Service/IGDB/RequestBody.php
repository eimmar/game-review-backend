<?php

declare(strict_types=1);




namespace App\Service\IGDB;

class RequestBody
{
    /**
     * @var string|null
     */
    private $fields;

    /**
     * @var string|null
     */
    private $where;

    /**
     * @var string|null
     */
    private $sort;

    /**
     * @var string|null
     */
    private $search;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @param string $fields
     * @param string $where
     * @param string $sort
     * @param string $search
     * @param int|null $limit
     * @param int|null $offset
     */
    public function __construct(string $fields = '', string $where = '', string $sort = '', string $search = '', int $limit = null, int $offset = null)
    {
        $this->fields = $fields;
        $this->where = $where;
        $this->sort = $sort;
        $this->search = $search;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function unwrap(): string
    {
        $unwrapped = '';
        $parts = [
            'fields' => trim($this->fields),
            'where' => trim($this->where),
            'sort' => trim($this->sort),
            'limit' => trim((string)$this->limit),
            'offset' => trim((string)$this->offset)
        ];

        foreach ($parts as $part => $value) {
            $unwrapped .= strlen($value) > 0 ? sprintf('%s %s;', $part, $value) : '';
        }
        $unwrapped .= strlen(trim($this->search)) > 0 ? sprintf('search "%s";', trim($this->search)) : '';

        return $unwrapped;
    }
}
