<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class HandleSubscriptions implements IncomingMessage
{
    private function __construct(
        public Domain\ValueObjects\UserId $userId,
        public string $additionalFieldName,
        public null|int|string $newAdditionalFieldValue,
        public null|int|string $oldAdditionalFieldValue,
        public Domain\ValueObjects\RoleId $roleId
    ) {

    }

    public static function new(
        Domain\ValueObjects\UserId $userId,
        string $additionalFieldName,
        null|int|string $newAdditionalFieldValue,
        null|int|string $oldAdditionalFieldValue,
        Domain\ValueObjects\RoleId $roleId,
    ) : self {
        return new self($userId, $additionalFieldName, $newAdditionalFieldValue, $oldAdditionalFieldValue, $roleId);
    }

    public function getName() : IncomingMessageName
    {
        return IncomingMessageName::ADDITIONAL_FIELD_VALUE_CHANGED;
    }

    public static function fromJson(string $json) : self
    {
        $obj = json_decode($json);
        return new self(
            Domain\ValueObjects\UserId::new(
                $obj->userId->id,
                $obj->userId->idType,
            ),
            $obj->additionalFieldName,
            $obj->newAdditionalFieldValue,
            $obj->oldAdditionalFieldValue,
            Domain\ValueObjects\RoleId::from($obj->roleId)
        );
    }
}