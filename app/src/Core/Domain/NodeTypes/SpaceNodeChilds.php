<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\NodeTypes;

interface SpaceNodeChilds
{
    public function appendSpaceId(string $spaceId): SpaceNodeChilds;

    public function getSpaceIds(): array;
}