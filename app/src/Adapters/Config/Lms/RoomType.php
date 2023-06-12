<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

enum RoomType: string implements Lms\Room
{
    case GENERAL_INFORMATIONS = "general_informations";
    case EXPERT_INFORMATIONS = "expert_informations";
    case LECTURER_INFORMATIONS = "lecturer_informations";
    case STUDENT_INFORMATIONS = "student_informations";
    case VOCATIONAL_TRAINER_INFORMATIONS = "faculty_vocational_trainer_informations";

    public function name(): string
    {
        return $this->value;
    }
}