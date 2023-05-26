<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\TreePorts;

enum UserGroup: string implements TreePorts\UserGroup
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
     * @return ?Role[]
     */
    public function roles(): ?array
    {
        return match ($this) {
            self::ADMINS => [Role::ADMINISTRATE],
            self::EXPERTS => [Role::EDIT],
            self::LECTURERS,
            self::STUDENTS,
            self::VOCATIONAL_TRAINERS => [Role::VIEW],
            self::STUDENTS_CLASS => null
        };
    }

    /**
     * @return ?Room[]
     */
    public function rooms(): ?array
    {
        return match ($this) {
            UserGroup::ADMINS,
            UserGroup::EXPERTS,
            UserGroup::LECTURERS,
            UserGroup::STUDENTS,
            UserGroup::VOCATIONAL_TRAINERS => [
                Room::USER_GROUP_COLLABORATION
            ],
            UserGroup::STUDENTS_CLASS => [
                Room::CLASS_ROOM
            ]
        };
    }
}
