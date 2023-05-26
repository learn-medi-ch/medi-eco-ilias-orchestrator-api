<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;

enum Space: string implements TreePorts\Space
{

    case UNITS = "units";
    case MEDI_AMB = "medi_AMB";
    case MEDI_AT = "medi_AT";
    case MEDI_BMA = "medi_BMA";
    case MEDI_DH = "medi_DH";
    case MEDI_MTR = "medi_MTR";
    case MEDI_OT = "medi_OT";
    case MEDI_RS = "medi_RS";
    case CLASSES = "classes";
    case CURRICULUMS = "curriculums";
    case PERSON_GROUPS_SPACE = "person_groups_space";


    public function name(): string
    {
        return $this->value;
    }

    public function spaces(): ?array
    {
        return match ($this) {
            Space::UNITS => [
                Space::MEDI_AMB,
                Space::MEDI_AT,
                Space::MEDI_BMA,
                Space::MEDI_DH,
                Space::MEDI_MTR,
                Space::MEDI_OT,
                Space::MEDI_RS
            ],
            Space::MEDI_AMB,
            Space::MEDI_AT,
            Space::MEDI_BMA,
            Space::MEDI_DH,
            Space::MEDI_MTR,
            Space::MEDI_OT,
            Space::MEDI_RS => [
                Space::PERSON_GROUPS_SPACE,
                Space::CLASSES,
                Space::CURRICULUMS,
            ]
        };
    }

    public function rooms(): ?array
    {
        return match ($this) {
            Space::UNITS => null,
            default => [Room::GENERAL_INFORMATIONS]
        };
    }


    public function userGroups(): ?array
    {
        return match ($this) {
            Space::UNITS => null,
            Space::MEDI_AMB,
            Space::MEDI_AT,
            Space::MEDI_BMA,
            Space::MEDI_DH,
            Space::MEDI_MTR,
            Space::MEDI_OT,
            Space::MEDI_RS => [
                UserGroup::ADMINS,
                UserGroup::EXPERTS,
                UserGroup::LECTURERS,
                UserGroup::STUDENTS,
                UserGroup::VOCATIONAL_TRAINERS,
            ]
        };
    }

    public function roles(): array
    {
        return match ($this) {
            Space::MEDI_AMB,
            Space::MEDI_AT,
            Space::MEDI_BMA,
            Space::MEDI_DH,
            Space::MEDI_MTR,
            Space::MEDI_OT,
            Space::MEDI_RS => $this->mediUnitRoles(), //todo with map?
            default => null
        };
    }

    public function mediUnitRoles(): array
    {
        $roles = [];
        foreach ($this->userGroups() as $userGroup) {
            $roles[] = match ($userGroup) {
                UserGroup::ADMINS,
                UserGroup::EXPERTS,
                UserGroup::VOCATIONAL_TRAINERS => $userGroup->roles(),
                default => null
            };
        }
        return $roles;
    }
}