<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

enum SpaceStructure: string implements Tree\SpaceStructure
{
    case ROOT = "root";
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

    public function uniqueName(): string
    {
        if ($this->parent() === null) {
            return $this->name();
        }
        return $this->parent()->uniqueName();
    }

    //todo build this and spaces structure from the same data structure
    public function parent(): ?Tree\SpaceStructure
    {
        return match ($this) {
            SpaceStructure::ROOT => null,
            SpaceStructure::UNITS => SpaceStructure::ROOT,
            SpaceStructure::MEDI_AMB,
            SpaceStructure::MEDI_AT,
            SpaceStructure::MEDI_BMA,
            SpaceStructure::MEDI_DH,
            SpaceStructure::MEDI_MTR,
            SpaceStructure::MEDI_OT,
            SpaceStructure::MEDI_RS => SpaceStructure::UNITS
        };
    }

    public function spaces(): ?array
    {
        return match ($this) {
            SpaceStructure::ROOT => [SpaceStructure::UNITS],
            SpaceStructure::UNITS => [
                SpaceStructure::MEDI_AMB,
                SpaceStructure::MEDI_AT,
                SpaceStructure::MEDI_BMA,
                SpaceStructure::MEDI_DH,
                SpaceStructure::MEDI_MTR,
                SpaceStructure::MEDI_OT,
                SpaceStructure::MEDI_RS
            ],
            SpaceStructure::MEDI_AMB,
            SpaceStructure::MEDI_AT,
            SpaceStructure::MEDI_BMA,
            SpaceStructure::MEDI_DH,
            SpaceStructure::MEDI_MTR,
            SpaceStructure::MEDI_OT,
            SpaceStructure::MEDI_RS => [
                SpaceStructure::PERSON_GROUPS_SPACE,
                SpaceStructure::CLASSES,
                SpaceStructure::CURRICULUMS,
            ]
        };
    }

    public function rooms(): ?array
    {
        return match ($this) {
            SpaceStructure::UNITS => null,
            default => [RoomStructure::GENERAL_INFORMATIONS]
        };
    }


    public function userGroups(): ?array
    {
        return match ($this) {
            SpaceStructure::UNITS => null,
            SpaceStructure::MEDI_AMB,
            SpaceStructure::MEDI_AT,
            SpaceStructure::MEDI_BMA,
            SpaceStructure::MEDI_DH,
            SpaceStructure::MEDI_MTR,
            SpaceStructure::MEDI_OT,
            SpaceStructure::MEDI_RS => [
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
            SpaceStructure::MEDI_AMB,
            SpaceStructure::MEDI_AT,
            SpaceStructure::MEDI_BMA,
            SpaceStructure::MEDI_DH,
            SpaceStructure::MEDI_MTR,
            SpaceStructure::MEDI_OT,
            SpaceStructure::MEDI_RS => $this->mediUnitRoles(), //todo with map?
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