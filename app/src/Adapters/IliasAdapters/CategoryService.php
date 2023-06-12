<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\IliasAdapters;

use FluxIliasBaseApi\Adapter\{Category\CategoryDiffDto, Object\ObjectDiffDto};
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;


final readonly class CategoryService
{
    private function __construct(
        private IliasRestApiClient $iliasRestApiClient,
    )
    {

    }

    public static function new(IliasRestApiClient $iliasRestApiClient): self
    {
        return new self(
            $iliasRestApiClient
        );
    }


    public function storeRootImportId(string $rootImportId): void
    {
        $this->storeImportIdToRefId($rootImportId, IliasRefIdType::CATEGORY_ROOT->value);
    }

    public function storeImportIdToRefId(string $importId, int $refId): void
    {
        $categoryDiffDto = ObjectDiffDto::new($importId);
        $this->iliasRestApiClient->updateObjectByRefId($refId, $categoryDiffDto);
    }


    public function createOrUpdate(string $parentImportId, string $importId, string $label): void
    {
        match ($this->iliasRestApiClient->getCategoryByImportId($importId)) {
            null => $this->create($parentImportId, $importId, $label),
            default => $this->update($importId, $label)
        };
    }

    private function update(string $importId, string $label): void
    {
        $categoryDiffDto = CategoryDiffDto::new($importId, $label);
        $this->iliasRestApiClient->updateCategoryByImportId($importId, $categoryDiffDto);
    }

    private function create(string $parentImportId, string $importId, string $label): void
    {
        $categoryDiffDto = CategoryDiffDto::new($importId, $label);
        $this->iliasRestApiClient->createCategoryToImportId($parentImportId, $categoryDiffDto);
    }
}