<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class MediRoleRemoved implements OutgoingMessage
{
    private function __construct(
        public ValueObjects\UserId $userId,
        public ValueObjects\MediRole $mediRole,
    ) {

    }

    public static function new(
        ValueObjects\UserId $userId,
        ValueObjects\MediRole $mediRole,
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }

    public function getName() : OutgoingMessageName
    {
        return OutgoingMessageName::MEDI_ROLE_REMOVED;
    }

    public function getAddress() : string
    {
        return $this->mediRole->facultyId->toUrlParameter() . "/" . $this->mediRole->roleId->toUrlParameter() . "/" . $this->getName()->value;
    }
}