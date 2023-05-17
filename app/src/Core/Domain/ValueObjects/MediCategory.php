<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

/**
 * @property Id $id
 * @property string $title
 */
class MediCategory implements Category
{
    private function __construct(
        Id     $id,
        string $title
    )
    {

    }

    public static function fromImportId(string $importId, $title): self
    {
        return new self(
            ImportId::new($importId),
            $title
        );
    }
}