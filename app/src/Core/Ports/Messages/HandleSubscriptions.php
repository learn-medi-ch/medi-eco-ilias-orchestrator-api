<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class HandleSubscriptions implements IncomingMessage
{
    private function __construct(
        public Domain\ValueObjects\UserImportId $userId,
        public string                           $additionalFieldName,
        public null|int|string                  $newAdditionalFieldValue,
        public null|int|string                  $oldAdditionalFieldValue,
        public Domain\ValueObjects\RoleIdSuffix $roleId
    ) {

    }

    public static function new(
        Domain\ValueObjects\UserImportId $userId,
        string                           $additionalFieldName,
        null|int|string                  $newAdditionalFieldValue,
        null|int|string                  $oldAdditionalFieldValue,
        Domain\ValueObjects\RoleIdSuffix $roleId,
    ) : self {
        return new self($userId, $additionalFieldName, $newAdditionalFieldValue, $oldAdditionalFieldValue, $roleId);
    }

    public function getName() : IncomingMessageName
    {
        return IncomingMessageName::HANDLE_SUBSCRIPTIONS;
    }

    public static function fromJson(string $json) : self
    {
        $obj = json_decode($json);
        return new self(
            Domain\ValueObjects\UserImportId::new(
                $obj->userId->id,
                $obj->userId->idType,
            ),
            $obj->additionalFieldName,
            $obj->newAdditionalFieldValue,
            $obj->oldAdditionalFieldValue,
            Domain\ValueObjects\RoleIdSuffix::from($obj->roleId)
        );
    }
}