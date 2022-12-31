<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Ports\User;

use MediEco\IliasUserOrchestratorApi\Core\Domain\ValueObjects;

class UserDto
{
    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     */
    private function __construct(
        public readonly ValueObjects\UserId $userId,
        public readonly ValueObjects\UserData $userData,
        public readonly array $additionalFields
    ) {

    }

    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     * @return static
     */
    public static function new(
        ValueObjects\UserId $userId,
        ValueObjects\UserData $userData,
        array $additionalFields
    ) : self {
        return new self(...get_defined_vars());
    }
}