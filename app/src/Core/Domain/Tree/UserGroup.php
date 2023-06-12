<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

final readonly class UserGroup
{
    private function __construct(
        public string $uniqueName,
        public string $label
    )
    {

    }


    public static function new(
        string $uniqueName,
        string $label
    ): self
    {
        return new self(...get_defined_vars());
    }

}
