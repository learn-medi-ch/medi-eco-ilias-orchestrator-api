<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediDictonary: string
{
    case ADDITIONAL_FIELD_NAME_STUDENT_FACULTIES = "BG Studierende";
    case ADDITIONAL_FIELD_NAME_SCHOOL_CLASS = "Ausbildungskurs (Klasse)";
    case ADDITIONAL_FIELD_NAME_VOCATIONAL_TRAINER_FACULTIES = "BG Berufsbildende"; //comma separated string
    case ADDITIONAL_FIELD_NAME_LECTURER_FACULTIES = "BG Dozierende"; //comma separated string
    case ADDITIONAL_FIELD_NAME_ADMIN_FACULTIES = "BG Admin"; //comma separated string
    case ADDITIONAL_FIELD_NAME_EXPERT_FACULTIES = "BG Fachteam"; //comma separated string
}