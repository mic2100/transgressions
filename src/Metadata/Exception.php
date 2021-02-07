<?php

declare(strict_types=1);

namespace Transgressions\Metadata;

use JsonSerializable;
use Transgressions\Formatters\StackTrace;
use Throwable;

class Exception implements JsonSerializable
{
    /**
     * @var Throwable
     */
    private Throwable $throwable;

    /**
     * Throwable constructor.
     *
     * @param Throwable $throwable
     */
    public function __construct(Throwable $throwable)
    {
        $this->throwable = $throwable;
    }

    public function toArray()
    {
        $previous = [];
        if ($this->throwable->getPrevious() instanceof Throwable) {
            $previous = (new static($this->throwable->getPrevious()))->toArray();
        }

        $stackTrace = StackTrace::create()->get($this->throwable);

        return [
            'message' => $this->throwable->getMessage(),
            'file' => $this->throwable->getFile(),
            'line' => $this->throwable->getLine(),
            'code' => $this->throwable->getCode(),
            'previous' => $previous,
            'trace' => $stackTrace,
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
