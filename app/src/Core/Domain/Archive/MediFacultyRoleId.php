<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediFacultyRoleId: string
{
    case FACULTY_STUDENTS = "faculty-students";
    case FACULTY_LECTURERS = "faculty-lecturers";
    case FACULTY_EXPERTS = "faculty-experts";
    case FACULTY_ADMINS = "faculty-admins";
    case FACULTY_VOCATIONAL_TRAINERS = "faculty-vocational-trainers";


    public function toImportId(string $facultyId): string
    {
        return "role_" . $facultyId . "-" . $this->value;
    }

    public function toTitle(?string $facultyId): string //todo think about secondParameter label
    {
        return match ($this) {
            MediFacultyRoleId::FACULTY_STUDENTS => "BG_" . strtoupper($facultyId) . "_Studierende",
            MediFacultyRoleId::FACULTY_LECTURERS => "BG_" . strtoupper($facultyId) . "_Dozierende",
            MediFacultyRoleId::FACULTY_EXPERTS => "BG_" . strtoupper($facultyId) . "_Fachteam",
            MediFacultyRoleId::FACULTY_ADMINS => "BG_" . strtoupper($facultyId) . "_Admin",
            MediFacultyRoleId::FACULTY_VOCATIONAL_TRAINERS => "BG_" . strtoupper($facultyId) . "_Berufsbildende",
        };
    }
}