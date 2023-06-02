<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

interface SpaceNodeChilds
{
    public function appendSpaceId(string $spaceId): SpaceNodeChilds;

    public function getSpaceIds(): array;
}