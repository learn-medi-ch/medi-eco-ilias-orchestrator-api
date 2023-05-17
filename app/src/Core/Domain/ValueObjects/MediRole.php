<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

final readonly class MediRole implements Role
{
    private function __construct(
        public string $importId,
        public int    $roleId,
        public string $title
    )
    {

    }

    public static function new(
        string $importId,
        int    $roleId,
        string $title
    ): self
    {
        return new self(...get_defined_vars());
    }
}