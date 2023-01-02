<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class UserId
{
    private function __construct(
        public string $id,
        public string $idType
    ) {

    }

    public static function new(
        string $id,
        string $idType
    ) : self {
        return new self(
            $id,
            $idType
        );
    }

    public static function fromAddressNr(
        string $addressNr
    ) : self {
        return new self(
            "medi-address_nr-" . $addressNr,
            $idType = "import-id"
        );
    }

    public function isEqual(UserId $obj) : bool
    {
        return (serialize($this) === serialize($obj));
    }
}