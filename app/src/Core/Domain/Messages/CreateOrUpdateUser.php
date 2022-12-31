<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Domain\Messages;
use MediEco\IliasUserOrchestratorApi\Core\Domain\ValueObjects;

class CreateOrUpdateUser implements Message
{
    private function __construct(
        public ValueObjects\UserId $userId,
        public ValueObjects\UserData $userData,
        public array $additionalFields
    ) {

    }

    public static function new(
        ValueObjects\UserId $userId,
        ValueObjects\UserData $userData,
        array $additionalFields
    ): self  {
        return new self(
            ...get_defined_vars()
        );
    }

    public function getName() : MessageName
    {
        return MessageName::CREATE_OR_UPDATE_USER;
    }
}