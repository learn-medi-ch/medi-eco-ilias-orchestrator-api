<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

/**
 * @property Id $id
 * @property string $title
 */
//todo think about - course like here or mediCourse like mediCategory and vice versa
class Course
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