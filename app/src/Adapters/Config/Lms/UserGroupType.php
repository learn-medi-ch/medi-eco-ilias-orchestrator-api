<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Lms;

enum UserGroupType: string implements Lms\UserGroup
{
    case ADMINS = "admins";
    case EXPERTS = "experts";
    case LECTURERS = "lecturers";
    case STUDENTS = "students";
    case VOCATIONAL_TRAINERS = "faculty-vocational-trainers";
    case STUDENTS_CLASS = "students_class";

    function name(): string
    {
        return $this->value;
    }


    /**
     * @return ?RoleType[]
     */
    public function roles(): ?array
    {
        return match ($this) {
            self::ADMINS => [RoleType::ADMINISTRATE],
            self::EXPERTS => [RoleType::EDIT],
            self::LECTURERS,
            self::STUDENTS,
            self::VOCATIONAL_TRAINERS => [RoleType::VIEW],
            self::STUDENTS_CLASS => null
        };
    }

    /**
     * @return ?RoomType[]
     */
    public function rooms(): ?array
    {
        return match ($this) {
            UserGroupType::ADMINS,
            UserGroupType::EXPERTS,
            UserGroupType::LECTURERS,
            UserGroupType::STUDENTS,
            UserGroupType::VOCATIONAL_TRAINERS => [
                RoomType::USER_GROUP_COLLABORATION
            ],
            UserGroupType::STUDENTS_CLASS => [
                RoomType::CLASS_ROOM
            ]
        };
    }
}
