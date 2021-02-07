<?php


namespace Transgressions\Metadata;


interface StandardMetadataInterface
{
    /**
     * Gets the name of the metadata group
     *
     * @return string
     */
    public function getGroupName(): string;
}
