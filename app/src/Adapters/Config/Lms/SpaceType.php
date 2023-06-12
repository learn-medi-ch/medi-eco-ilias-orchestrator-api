<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

enum SpaceType: string implements Lms\Space
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
            SpaceType::ROOT => [SpaceType::UNITS],
            SpaceType::UNITS => [
                SpaceType::AMB,
                SpaceType::AT,
                SpaceType::BMA,
                SpaceType::DH,
                SpaceType::MTR,
                SpaceType::OT,
                SpaceType::RS
            ],
            SpaceType::AMB,
            SpaceType::AT,
            SpaceType::BMA,
            SpaceType::DH,
            SpaceType::MTR,
            SpaceType::OT,
            SpaceType::RS => [
                SpaceType::PERSON_GROUPS,
                SpaceType::CLASSES,
                SpaceType::CURRICULUMS,
            ],
            self::CLASSES, self::CURRICULUMS, self::PERSON_GROUPS => []
        };
    }

    public function rooms(): array
    {
        return match ($this) {
            SpaceType::AMB,
            SpaceType::AT,
            SpaceType::BMA,
            SpaceType::DH,
            SpaceType::MTR,
            SpaceType::OT,
            SpaceType::RS => [RoomType::GENERAL_INFORMATIONS],
            SpaceType::PERSON_GROUPS => [
                RoomType::EXPERT_INFORMATIONS, RoomType::LECTURER_INFORMATIONS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS, RoomType::STUDENT_INFORMATIONS
            ],
            default => []
        };
    }


    public function userGroups(): array
    {
        return match ($this) {
            SpaceType::UNITS => [],
            SpaceType::AMB,
            SpaceType::AT,
            SpaceType::BMA,
            SpaceType::DH,
            SpaceType::MTR,
            SpaceType::OT,
            SpaceType::RS => [
                UserGroupType::ADMINS,
                UserGroupType::EXPERTS,
                UserGroupType::LECTURERS,
                UserGroupType::STUDENTS,
                UserGroupType::VOCATIONAL_TRAINERS,
            ]
        };
    }

    public function roles(): array
    {
        return match ($this) {
            SpaceType::AMB,
            SpaceType::AT,
            SpaceType::BMA,
            SpaceType::DH,
            SpaceType::MTR,
            SpaceType::OT,
            SpaceType::RS => $this->mediUnitRoles(), //todo with map?
            default => []
        };
    }

    public function mediUnitRoles(): array
    {
        $roles = [];
        foreach ($this->userGroups() as $userGroup) {
            $roles[] = match ($userGroup) {
                UserGroupType::ADMINS,
                UserGroupType::EXPERTS,
                UserGroupType::VOCATIONAL_TRAINERS => $userGroup->roles(),
                default => []
            };
        }
        return $roles;
    }
}