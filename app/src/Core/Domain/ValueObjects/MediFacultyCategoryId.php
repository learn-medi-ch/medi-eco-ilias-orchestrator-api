<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediFacultyCategoryId: string
{
    case FACULTY_ROOT = "faculty-root";
    case FACULTY_SCHOOL_CLASSES = "faculty-school-classes";
    case FACULTY_GROUPES = "faculty-groupes";
    case FACULTY_CURRICULUM = "faculty-curriculum";


    public function toImportId(string $facultyId): string
    {
        return  "cat_" . $facultyId . "-" . $this->value;
    }

    public function toRoleTitle(?string $facultyId): string
    {
        return match ($this) {
            MediFacultyCategoryId::FACULTY_ROOT => strtoupper($facultyId),
            MediFacultyCategoryId::FACULTY_SCHOOL_CLASSES => "Klassen",
            MediFacultyCategoryId::FACULTY_GROUPES => "Gremien",
            MediFacultyCategoryId::FACULTY_CURRICULUM => "Stoffplan",
        };
    }
}