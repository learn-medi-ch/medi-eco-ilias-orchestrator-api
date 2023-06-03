<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

enum SpaceStructure: string implements Tree\SpaceStructure
{
    case ROOT = "root";
    case UNITS = "units";
    case AMB = "amb";
    case AT = "at";
    case BMA = "bma";
    case DH = "dh";
    case MTR = "mtr";
    case OT = "ot";
    case RS = "rs";
    case CLASSES = "classes";
    case CURRICULUMS = "curriculums";
    case PERSON_GROUPS = "personGroups";


    public function name(): string
    {
        return $this->value;
    }

    public function spaces(): array
    {
        return match ($this) {
            SpaceStructure::ROOT => [SpaceStructure::UNITS],
            SpaceStructure::UNITS => [
                SpaceStructure::AMB,
                SpaceStructure::AT,
                SpaceStructure::BMA,
                SpaceStructure::DH,
                SpaceStructure::MTR,
                SpaceStructure::OT,
                SpaceStructure::RS
            ],
            SpaceStructure::AMB,
            SpaceStructure::AT,
            SpaceStructure::BMA,
            SpaceStructure::DH,
            SpaceStructure::MTR,
            SpaceStructure::OT,
            SpaceStructure::RS => [
                SpaceStructure::PERSON_GROUPS,
                SpaceStructure::CLASSES,
                SpaceStructure::CURRICULUMS,
            ],
            self::CLASSES, self::CURRICULUMS, self::PERSON_GROUPS => []
        };
    }

    public function rooms(): array
    {
        return match ($this) {
            SpaceStructure::UNITS => [],
            default => [RoomStructure::GENERAL_INFORMATIONS]
        };
    }


    public function userGroups(): array
    {
        return match ($this) {
            SpaceStructure::UNITS => [],
            SpaceStructure::AMB,
            SpaceStructure::AT,
            SpaceStructure::BMA,
            SpaceStructure::DH,
            SpaceStructure::MTR,
            SpaceStructure::OT,
            SpaceStructure::RS => [
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
            SpaceStructure::AMB,
            SpaceStructure::AT,
            SpaceStructure::BMA,
            SpaceStructure::DH,
            SpaceStructure::MTR,
            SpaceStructure::OT,
            SpaceStructure::RS => $this->mediUnitRoles(), //todo with map?
            default => []
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
                default => []
            };
        }
        return $roles;
    }
}