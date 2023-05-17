<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class MediStaffData implements UserData
{
    public string $login;
    public string $authMode;
    public string $externalId;


    private function __construct(
        public MediUserImportId $importId,
        public string           $email,
        public string           $firstName,
        public string           $lastName,
        public array            $roleIds,
        public array            $additionalFields
    )
    {
        $this->login = $email;
        $this->externalId = $email;
        $this->authMode = "default"; //todo oidc https://github.com/fluxfw/flux-tasks/issues/108
    }

    /**
     * @return static
     */
    public static function new(
        MediUserImportId $importId,
        string           $email,
        string           $firstName,
        string           $lastName,
        array            $roleIds,
        string           $lecturerFaculty,
        string           $expertFaculty,
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
                    MediDictonary::ADDITIONAL_FIELD_NAME_LECTURER_FACULTIES->value,
                    $lecturerFaculty
                ),
                AdditionalField::new(
                    MediDictonary::ADDITIONAL_FIELD_NAME_EXPERT_FACULTIES->value,
                    $expertFaculty
                ),
            ]
        );
    }

    public function isEqual(MediStudentData $userData): bool
    {
        return (serialize($this) === serialize($userData));
    }
}