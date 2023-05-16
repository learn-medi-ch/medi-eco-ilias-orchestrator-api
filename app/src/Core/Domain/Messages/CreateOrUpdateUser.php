<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class CreateOrUpdateUser implements OutgoingMessage
{
    private function __construct(
        public ValueObjects\UserImportId    $userId,
        public ValueObjects\MediStudentData $userData,
        public array                        $additionalFields
    ) {

    }

    public static function new(
        ValueObjects\UserImportId    $userId,
        ValueObjects\MediStudentData $userData,
        array                        $additionalFields
    ): self  {
        return new self(
            ...get_defined_vars()
        );
    }

    public function getName() : OutgoingMessageName
    {
        return OutgoingMessageName::CREATE_OR_UPDATE_USER;
    }

    public function getAddress() : string
    {
        return  OutgoingMessageName::CREATE_OR_UPDATE_USER->value;
    }
}