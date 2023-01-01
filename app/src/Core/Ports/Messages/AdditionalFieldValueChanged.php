<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;

class AdditionalFieldValueChanged implements IncomingMessage
{
    private function __construct(
        public string $userId,
        public string $additionalFieldName,
        public null|int|string $newAdditionalFieldValue,
        public null|int|string $oldAdditionalFieldValue
    ) {

    }

    public static function new(
        string $userId,
        string $additionalFieldName,
        null|int|string $newAdditionalFieldValue,
        null|int|string $oldAdditionalFieldValue
    ) : self {
        return new self($userId, $additionalFieldName, $newAdditionalFieldValue, $oldAdditionalFieldValue);
    }

    public function getName() : IncomingMessageName
    {
        return IncomingMessageName::ADDITIONAL_FIELD_VALUE_CHANGED;
    }

    public static function fromJson(string $json) : self
    {
        $obj = json_decode($json);
        return new self(
            $obj->userId,
            $obj->additionalFieldName,
            $obj->newAdditionalFieldValue,
            $obj->oldAdditionalFieldValue
        );
    }
}