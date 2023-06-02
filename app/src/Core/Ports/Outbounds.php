<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\{Label, Tree};
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

final readonly class Outbounds
{

    private function __construct(
        public Label\Dictionary  $dictionary,
        public Tree\Repositories $repositories,
    )
    {

    }

    public static function new(
        Config               $config,
        Tree\Repository $spaceRepository,
        Tree\Repository $roomRepository,
        Tree\Repository $roleRepository
    )
    {
        return new self($config->dictionary(), Tree\Repositories::new($spaceRepository, $roomRepository, $roleRepository));
    }
}