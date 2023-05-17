<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

readonly class MediExternalUserData implements UserData
{
    public string $login;
    public string $authMode;
    public string $externalId;


    private function __construct(
        public string $importId,
        public string           $email,
        public string           $firstName,
        public string           $lastName,
        public array            $roleImportIds,
        public array            $additionalFields
    )
    {
        $this->login = $email;
        $this->externalId = "";
        $this->authMode = "default";
    }

    /**
     * @return static
     */
    public static function new(
        string $importId,
        string           $email,
        string           $firstName,
        string           $lastName,
        array            $roleIds,
        string           $vocationalTrainerFaculties
    ): self
    {
        return new self(
            $importId,
            $email,
            $firstName,
            $lastName,
            $roleIds,
            [
                AdditionalField::new(
                    MediDictonary::ADDITIONAL_FIELD_NAME_VOCATIONAL_TRAINER_FACULTIES->value,
                    $vocationalTrainerFaculties
                )
            ]
        );
    }

    public function isEqual(MediStudentData $userData): bool
    {
        return (serialize($this) === serialize($userData));
    }
}