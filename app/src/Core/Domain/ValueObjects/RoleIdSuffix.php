<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum RoleIdSuffix: string
{
    case FACULTY_STUDENTS = "faculty-students";
    case FACULTY_LECTURERS = "faculty-lecturers";
    case LECTURERS = "lecturers";
    case FACULTY_EXPERTS = "faculty-experts";
    case FACULTY_ADMINS = "faculty-admins";
    case FACULTY_VOCATIONAL_TRAINERS = "faculty-vocational-trainers";
    case ADMINS = "admins";
    case MEDI_STAFF = "medi-staff";
    case MEDI_SANDBOX = "medi-sandbox";


    public function toUrlParameter(): string
    {
        return "role-id/" . $this->value;
    }

    public function toRoleImportId(string $facultyId = ""): string
    {
        return match ($this) {
            RoleIdSuffix::FACULTY_STUDENTS => "role_" . $facultyId . "-" . $this->value,
            RoleIdSuffix::FACULTY_LECTURERS => "role_" . $facultyId . "-" . $this->value,
            RoleIdSuffix::LECTURERS => "role_faculty-" . $this->value,
            RoleIdSuffix::FACULTY_EXPERTS => "role_" . $facultyId . "-" . $this->value,
            RoleIdSuffix::FACULTY_ADMINS => "role_" . $facultyId . "-" . $this->value,
            RoleIdSuffix::FACULTY_VOCATIONAL_TRAINERS => "role_" . $facultyId . "-" . $this->value,
            RoleIdSuffix::ADMINS => "role_faculty-" . $this->value,
            RoleIdSuffix::MEDI_STAFF => "role_" . $this->value,
            RoleIdSuffix::MEDI_SANDBOX => "role_" . $this->value,
        };
    }
}