<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediGeneralRoleId: string
{
    case LECTURERS = "faculty-lecturers";
    case ADMINS = "faculty-admins";
    case MEDI_STAFF = "medi-staff";
    case MEDI_SANDBOX = "medi-sandbox";


    public function toUrlParameter(): string
    {
        return "role-id/" . $this->value;
    }

    public function toImportId(): string
    {
        return "role_" . $this->value;
    }

    public function toRoleTitle(): string
    {
        //todo
        return match ($this) {
            MediGeneralRoleId::LECTURERS => "role_" . $this->value,
            MediGeneralRoleId::ADMINS => "role_" . $this->value,
            MediGeneralRoleId::MEDI_STAFF => "role_" . $this->value,
            MediGeneralRoleId::MEDI_SANDBOX => "role_" . $this->value,
        };
    }
}