<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

final readonly class Path
{

    private function __construct(
        public array $fragments
    )
    {

    }

    public static function new(
        array $fragments
    )
    {
        return new self(array_filter($fragments));
    }

    public function toKebabCase(): string
    {
        return implode("-", $this->fragments);
    }
}