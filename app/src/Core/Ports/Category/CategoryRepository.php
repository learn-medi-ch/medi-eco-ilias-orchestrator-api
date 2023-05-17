<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Category;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface CategoryRepository
{
    public function getCategoryByImportId(string $importId): ?Domain\ValueObjects\MediCategory;

    public function createCategoryToRootNode(string $importId, string $title): void;

    public function createCategory(string $parentImportId, string $importId, string $title): void;
}