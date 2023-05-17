<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class UserDto
{
    public array $additionalFields;

    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     */
    private function __construct(
        public readonly ValueObjects\MediUserImportId $userId,
        public readonly ValueObjects\MediStudentData  $userData,
        array                                         $additionalFields
    ) {
        foreach($additionalFields as $additionalField) {
            $this->additionalFields[$additionalField->fieldName] = $additionalField;
        }
    }

    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     * @return static
     */
    public static function new(
        ValueObjects\MediUserImportId $userId,
        ValueObjects\MediStudentData  $userData,
        array                         $additionalFields
    ) : self {
        return new self(...get_defined_vars());
    }
}