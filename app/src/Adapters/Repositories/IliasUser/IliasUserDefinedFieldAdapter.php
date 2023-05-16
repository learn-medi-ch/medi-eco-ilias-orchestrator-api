<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\IliasUser;
use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\User\UserDefinedFieldDto;
use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\User\UserDiffDto;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;
use stdClass;

class IliasUserDefinedFieldAdapter
{

    private function __construct(
        public array $userDefinedFieldDtos
    )
    {

    }

    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     * @return IliasUserDefinedFieldAdapter
     */
    public static function fromDomain(
        array $additionalFields,
    )
    {
        $userDefinedFieldDtos = [];
        foreach ($additionalFields as $additionalField) {
            $object = new stdClass();
            $object->name = $additionalField->fieldName;
            $object->value = $additionalField->fieldValue;
            $userDefinedFieldDtos[] = UserDefinedFieldDto::newFromObject(
                $object
            );
        }

        return new self($userDefinedFieldDtos);
    }

    public function toUserDiffDto(): UserDiffDto
    {
        $user = new stdClass();
        $user->user_defined_fields = $this->userDefinedFieldDtos;

        return UserDiffDto::newFromObject($user);
    }
}