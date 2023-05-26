<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports\{TreePorts};

final readonly class Repositories
{

    private function __construct(
        public TreePorts\Repository $spaceRepository,
        public TreePorts\Repository $roomRepository,
        public TreePorts\Repository $roleRepository
    )
    {

    }

    public static function new(
        TreePorts\Repository $spaceRepository,
        TreePorts\Repository $roomRepository,
        TreePorts\Repository $roleRepository
    )
    {
        return new self(...get_defined_vars());
    }
}