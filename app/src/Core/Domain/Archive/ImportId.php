<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;


final readonly class ImportId implements Id
{
    public string $idType;

    private function __construct(
        public string $id
    )
    {
        $idType = IdType::IMPORT_ID->value;
    }

    public static function new(string $id): self
    {
        return new self(...get_defined_vars());
    }
}