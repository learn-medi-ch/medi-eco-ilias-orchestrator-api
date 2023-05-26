<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

readonly class MediStudentData implements UserData
{
    public string $login;
    public string $authMode;

    public string $externalId;


    private function __construct(
        public string $importId,
        public string $email,
        public string $firstName,
        public string $lastName,
        public array  $roleImportIds,
        public array  $additionalFields
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
        string $importId,
        string $email,
        string $firstName,
        string $lastName,
        array  $roleImportIds,
        string $studentFaculty,
        string $schoolClass
    ): self
    {
        return new self(
            $importId,
            $email,
            $firstName,
            $lastName,
            $roleImportIds,
            [
                AdditionalField::new(
                    MediDictonary::ADDITIONAL_FIELD_NAME_STUDENT_FACULTIES->value,
                    $studentFaculty
                ),
                AdditionalField::new(
                    MediDictonary::ADDITIONAL_FIELD_NAME_SCHOOL_CLASS->value,
                    $schoolClass
                ),
            ]
        );
    }

    public function isEqual(MediStudentData $userData): bool
    {
        return (serialize($this) === serialize($userData));
    }
}
