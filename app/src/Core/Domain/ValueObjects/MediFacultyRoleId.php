<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediFacultyRoleId: string
{
    case FACULTY_STUDENTS = "faculty-students";
    case FACULTY_LECTURERS = "faculty-lecturers";
    case FACULTY_EXPERTS = "faculty-experts";
    case FACULTY_ADMINS = "faculty-admins";
    case FACULTY_VOCATIONAL_TRAINERS = "faculty-vocational-trainers";


    public function toUrlParameter(): string
    {
        return "role-id/" . $this->value;
    }

    public function toRoleImportIdString(string $facultyId): string
    {
        return match ($this) {
            MediFacultyRoleId::FACULTY_STUDENTS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_LECTURERS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_EXPERTS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_ADMINS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_VOCATIONAL_TRAINERS => "role_" . $facultyId . "-" . $this->value,
        };
    }

    public function toRoleTitle(?string $facultyId): string
    {
        return match ($this) {
            MediFacultyRoleId::FACULTY_STUDENTS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_LECTURERS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_EXPERTS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_ADMINS => "role_" . $facultyId . "-" . $this->value,
            MediFacultyRoleId::FACULTY_VOCATIONAL_TRAINERS => "role_" . $facultyId . "-" . $this->value
        };
    }
}