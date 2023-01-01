<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class UserId {
    private function __construct(
        public string $id,
        public string $idType = "user-import-id"
    ) {

    }

    public static function new(
        string $id
    ): self
    {
        return new self(
            $id
        );
    }

    public static function fromAddressNr(
        string $addressNr
    ): self
    {
        return new self(
            "medi-address_nr-".$addressNr
        );
    }

    public function isEqual(string $id): bool {
        return ($this->id === $id);
    }
}