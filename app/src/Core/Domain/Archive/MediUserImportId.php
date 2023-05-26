<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

readonly class MediUserImportId implements Id
{
    public string $idType;

    private function __construct(
        public string $id
    )
    {
        $this->idType = "import-id";
    }

    public static function new(
        string $id
    ): self
    {
        return new self(
            $id
        );
    }

    public static function fromMediAddressNr(
        string $addressNr
    ): self
    {
        return new self(
            "medi-address_nr-" . $addressNr
        );
    }

    public function isEqual(MediUserImportId $obj): bool
    {
        return (serialize($this) === serialize($obj));
    }
}