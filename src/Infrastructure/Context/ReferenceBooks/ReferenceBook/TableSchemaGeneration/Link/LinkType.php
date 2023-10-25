<?php

namespace Infrastructure\Context\ReferenceBooks\ReferenceBook\TableSchemaGeneration\Link;

final class LinkType
{
    private ?string $key = null;

    private ?LinkTypeTarget $target = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getTarget(): ?LinkTypeTarget
    {
        return $this->target;
    }
}
