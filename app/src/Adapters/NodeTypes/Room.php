<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\NodeTypes;

use  MediEco\IliasUserOrchestratorOrbital\Core\Domain;

enum Room: string implements Domain\NodeTypes\Room
{
    case USER_GROUP_COLLABORATION = "user_group_collaboration";
    case GENERAL_INFORMATIONS = "general_informations";
    case CLASS_ROOM = "class_room";


    public function name(): string
    {
        return $this->name();
    }


}