<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;


final readonly class RoleNode
{
    private function __construct(
        public string $name,
        public string $uniqueName
    )
    {

    }

    public static function new(
        string $name,
        string $uniqueName,
    ): self
    {
        return new self(...get_defined_vars());
    }

}
