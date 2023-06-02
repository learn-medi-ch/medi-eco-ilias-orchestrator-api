<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\{Tree, System};

interface Transitions
{
    public function appendIndexedLabesToDictionary(array $labelDictionary, callable $language): array;

    /**
     * @param Tree\SpaceNode $parentSpaceNode
     * @param $spaces():Spaces[] $spaces
     * @return Tree\SpaceNode $spaceNode
     */
    public function createOrUpdateSpacesOfNode(Tree\SpaceNode $parentSpaceNode, callable $spaces): Tree\SpaceNode;
}