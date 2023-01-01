<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediRoleId: string
{
    case FACULTY_EXPERT = "faculty-expert";
    case FACULTY_ADMIN = "faculty-admin";
    case FACULTY_VOCATIONAL_TRAINER = "faculty-vocational-trainer";
    case FACULTY_STUDENT = "faculty-student";

    public function toUrlParameter(): string  {
        return "role-id/".$this->value;
    }
}