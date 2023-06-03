<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Tree;

enum RoomStructure: string implements Tree\RoomStructure
{
    case USER_GROUP_COLLABORATION = "user_group_collaboration";
    case GENERAL_INFORMATIONS = "general_informations";
    case CLASS_ROOM = "class_room";


    public function name(): string
    {
        return $this->name;
    }
}