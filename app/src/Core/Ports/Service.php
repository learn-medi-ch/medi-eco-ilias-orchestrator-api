<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

final class Service
{

    private function __construct(
        private Lms\Service    $lmsService,
        private States\Service $stateService,
        private Domain\Service $domainService
    )
    {

    }

    public static function new(
        Lms\Service    $lmsService,
        States\Service $stateService,
    ): Service
    {
        return new self($lmsService, $stateService, Domain\Service::new($stateService));
    }

    public function createOrUpdateTree(
        Lms\Space $rootSpace
    ): void
    {
        $rootSpaceNode = $this->domainService->newSpaceNode($rootSpace);
        $this->lmsService->initRootSpace();
        $this->createOrUpdateSpaceNodes($rootSpaceNode->uniqueName, $rootSpaceNode->spaceNodes);
    }

    /**
     * @param string $parentUniqueName
     * @param Domain\Tree\SpaceNode[] $spaceNodes
     * @return void
     */
    private function createOrUpdateSpaceNodes(string $parentUniqueName, array $spaceNodes): void
    {
        $this->stateService->newArrayState($spaceNodes)->map(fn($spaceNode) => $this->createOrUpdateSpaceNode($parentUniqueName, $spaceNode));
    }

    private function createOrUpdateSpaceNode(string $parentUniqueName, Domain\Tree\SpaceNode $spaceNode): void
    {
        $this->lmsService->createOrUpdateSpace($parentUniqueName, $spaceNode->uniqueName);

        $this->createOrUpdateSpaceNodes($spaceNode->uniqueName, $spaceNode->spaceNodes);
        $this->createOrUpdateRoomNodes($spaceNode->uniqueName, $spaceNode->roomNodes);
    }

    /**
     * @param string $parentUniqueName
     * @param Domain\Tree\RoomNode[] $roomNodes
     * @return void
     */
    private function createOrUpdateRoomNodes(string $parentUniqueName, array $roomNodes): void
    {
        $this->stateService->newArrayState($roomNodes)->map(fn($roomNode) => $this->createOrUpdateRoomNode($parentUniqueName, $roomNode));
    }

    private function createOrUpdateRoomNode(string $parentUniqueName, Domain\Tree\RoomNode $roomNode): void
    {
        $this->lmsService->createOrUpdateRoom($parentUniqueName, $roomNode->uniqueName);
    }
}