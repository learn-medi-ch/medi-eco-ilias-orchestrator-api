<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Adapters\IliasAdapters;


final readonly class Service implements Ports\Lms\Service
{

    private function __construct(
        private LanguageType                  $currentUserLanguage,
        private Labels                        $labels,
        private IliasAdapters\CategoryService $categoryService,
        private IliasAdapters\CourseService   $courseService
    )
    {

    }

    public static function new(
        LanguageType $currentUserLanguage
    ): self //todo instance
    {
        $iliasRestApiClient = IliasRestApiClient::new();

        return new self(
            $currentUserLanguage,
            Labels::new(),
            IliasAdapters\CategoryService::new($iliasRestApiClient),
            IliasAdapters\CourseService::new($iliasRestApiClient)
        );
    }

    public function createOrUpdateSpace(string $parentUniqueName, string $uniqueName): void
    {
        $this->categoryService->createOrUpdate($parentUniqueName, $uniqueName, $this->labels->read($this->currentUserLanguage, $uniqueName));
    }

    public function createOrUpdateRoom(string $parentUniqueName, string $uniqueName): void
    {
        $this->courseService->createOrUpdate($parentUniqueName, $uniqueName, $this->labels->read($this->currentUserLanguage, $uniqueName));
    }

    public function initRootSpace()
    {
        $this->categoryService->storeRootImportId(SpaceType::ROOT->value);
    }
}