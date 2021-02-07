<?php

declare(strict_types=1);

namespace Transgressions;

use Transgressions\Metadata\Exception as MetadataException;
use Transgressions\Metadata\StandardMetadataInterface;

final class Agitator
{
    /**
     * @var null|self
     */
    private static ?self $instance = null;

    /**
     * @var MetadataException|null - The metadata exception
     */
    private ?MetadataException $exception;

    /**
     * @var array
     */
    private array $metadata = [];

    /**
     * This is private so the singleton works
     */
    private function __construct()
    {

    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @return MetadataException|null
     */
    public function getException(): ?MetadataException
    {
        return $this->exception;
    }

    /**
     * @param MetadataException $exception
     */
    public function setException(MetadataException $exception): void
    {
        $this->exception = $exception;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param StandardMetadataInterface $metadata
     */
    public function addMetadata(StandardMetadataInterface $metadata): void
    {
        $this->metadata[$metadata->getGroupName()][] = $metadata;
    }

    /**
     * Converts the exception and metadata into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $metadata = [];
        foreach ($this->getMetadata() as $handle => $metadata) {
            foreach ($metadata as $metadatum) {
                $metadata[$handle][] = $metadatum->toArray();
            }
        }

        return [
            'exception' => $this->exception->toArray(),
            'metadata' => $metadata,
        ];
    }
}
