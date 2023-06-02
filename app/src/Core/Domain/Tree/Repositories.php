<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports\{Tree};

final readonly class Repositories
{

    private function __construct(
        public Tree\Repository $spaceRepository,
        public Tree\Repository $roomRepository,
        public Tree\Repository $roleRepository
    )
    {

    }

    public static function new(
        Tree\Repository $spaceRepository,
        Tree\Repository $roomRepository,
        Tree\Repository $roleRepository
    )
    {
        return new self(...get_defined_vars());
    }
}