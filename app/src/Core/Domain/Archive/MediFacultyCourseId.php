<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediFacultyCourseId: string
{
    case FACULTY_GROUP_VOCATIONAL_TRAINERS = "faculty-group-vocational-trainers";
    case FACULTY_GROUP_LECTURERS = "faculty-group-lecturers";
    case FACULTY_GROUP_EXPERTS = "faculty-group-experts";
    case FACULTY_GROUP_STUDENTS = "faculty-group-students";

    public function toCourseImportId(string $facultyId): string
    {
        return "crs_" . $facultyId . "-" . $this->value;
    }

    public function toCourseTitle(?string $facultyId): string
    {
        return match ($this) {
            MediFacultyCourseId::FACULTY_GROUP_VOCATIONAL_TRAINERS => "Gremium Berufsbildende " . strtoupper($facultyId),
            MediFacultyCourseId::FACULTY_GROUP_LECTURERS => "Gremium Dozierende " . strtoupper($facultyId),
            MediFacultyCourseId::FACULTY_GROUP_EXPERTS => "Gremium Fachteam " . strtoupper($facultyId),
            MediFacultyCourseId::FACULTY_GROUP_STUDENTS => "Gremium Studierende " . strtoupper($facultyId),
        };
    }
}