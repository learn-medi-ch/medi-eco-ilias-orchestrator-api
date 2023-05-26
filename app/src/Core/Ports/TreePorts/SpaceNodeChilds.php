<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;

interface SpaceNodeChilds
{
    public function appendSpaceId(string $spaceId): SpaceNodeChilds;

    public function getSpaceIds(): array;
}