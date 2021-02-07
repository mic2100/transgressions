<?php

declare(strict_types=1);

namespace Transgressions\Metadata;

class Query implements StandardMetadataInterface
{
    public const GROUP_NAME = 'query';

    /**
     * @var string|null
     */
    private ?string $sql;

    /**
     * @var array|null
     */
    private ?array $bindings;

    /**
     * @var float|null
     */
    private ?float $time;

    /**
     * Query constructor.
     *
     * @param string $sql
     * @param array $bindings
     * @param float $time
     */
    public function __construct(string $sql, array $bindings, float $time)
    {
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->time = $time;
    }

    /**
     * @inheritdoc
     */
    public function getGroupName(): string
    {
        return self::GROUP_NAME;
    }

    /**
     * Returns the array structure of the query data
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'sql' => $this->sql,
            'bindings' => $this->bindings,
            'time' => $this->time,
        ];
    }
}
