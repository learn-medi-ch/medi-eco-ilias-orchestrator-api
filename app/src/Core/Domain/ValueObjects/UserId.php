<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Domain\ValueObjects;

class UserId {
    private function __construct(
        public string $id
    ) {

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