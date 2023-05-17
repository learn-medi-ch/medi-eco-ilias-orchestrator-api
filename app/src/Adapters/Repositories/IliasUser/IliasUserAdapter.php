<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\IliasUser;

use FluxIliasBaseApi\Adapter\User\UserDiffDto;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\{MediStudentData, UserData, MediUserImportId};
use stdClass;

class IliasUserAdapter
{

    private function __construct(
        public object $userObject
    )
    {

    }

    public static function fromDomain(
        UserData $userData,
    )
    {
        $userObject = new stdClass();
        $userObject->import_id = $userData->importId->id;
        $userObject->login = $userData->login;
        $userObject->active = true;
        $userObject->first_name = $userData->firstName;
        $userObject->last_name = $userData->lastName;
        $userObject->email = $userData->email;
        $userObject->language = 'german';
        // //todo if @medi / @medi-bern -> authmod oidc
        $userObject->authentication_mode = $userData->authMode;
        $userObject->external_account = $userData->externalId; //todo if @medi / @medi-bern
        return new self($userObject);
    }

    public function toUserDiffDto(): UserDiffDto
    {
        return UserDiffDto::newFromObject(
            $this->userObject
        );
    }
}