<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class RoleRemoved implements OutgoingMessage
{
    private function __construct(
        public ValueObjects\UserId $userId,
        public ValueObjects\Role $mediRole,
    ) {

    }

    public static function new(
        ValueObjects\UserId $userId,
        ValueObjects\Role $mediRole,
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }

    public function getName() : OutgoingMessageName
    {
        return OutgoingMessageName::ROLE_REMOVED;
    }

    public function getAddress() : string
    {
        return $this->mediRole->facultyId->toUrlParameter() . "/" . $this->mediRole->roleId->toUrlParameter() . "/" . $this->getName()->value;
    }
}