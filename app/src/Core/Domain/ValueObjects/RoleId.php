<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum RoleId: string
{
    case FACULTY_EXPERT = "faculty-expert";
    case FACULTY_ADMIN = "faculty-admin";
    case FACULTY_LECTURER = "faculty-lecturer";
    case FACULTY_VOCATIONAL_TRAINER = "faculty-vocational-trainer";
    case FACULTY_STUDENT = "faculty-student";

    public function toUrlParameter(): string  {
        return "role-id/".$this->value;
    }

    public function toFieldName(): string {
        return match($this) {
            self::FACULTY_EXPERT => "BG Fachteam",
            self::FACULTY_ADMIN  => "BG Admin",
            self::FACULTY_LECTURER  => "BG Dozierende",
            self::FACULTY_VOCATIONAL_TRAINER  => "BG Berufsbildende",
            self::FACULTY_STUDENT  => "BG Studierende"
        };
    }
}