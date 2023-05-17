<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediGeneralRoleId: string
{
    case LECTURERS = "lecturers";
    case ADMINS = "admins";
    case MEDI_STAFF = "medi-staff";
    case MEDI_SANDBOX = "medi-sandbox";


    public function toUrlParameter(): string
    {
        return "role-id/" . $this->value;
    }

    public function toRoleImportIdString(): string
    {
        return match ($this) {
            MediGeneralRoleId::LECTURERS => "role_faculty-" . $this->value,
            MediGeneralRoleId::ADMINS => "role_faculty-" . $this->value,
            MediGeneralRoleId::MEDI_STAFF => "role_" . $this->value,
            MediGeneralRoleId::MEDI_SANDBOX => "role_" . $this->value,
        };
    }

    public function toRoleTitle(): string
    {
        return match ($this) {
            MediGeneralRoleId::LECTURERS => "role_faculty-" . $this->value,
            MediGeneralRoleId::ADMINS => "role_faculty-" . $this->value,
            MediGeneralRoleId::MEDI_STAFF => "role_" . $this->value,
            MediGeneralRoleId::MEDI_SANDBOX => "role_" . $this->value,
        };
    }
}