<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;

enum IncomingMessageName: string
{
    case IMPORT_USERS = "import-users";
    case HANDLE_SUBSCRIPTIONS = "handle-subscriptions";
    case HANDLE_DEGREE_SUBSCRIPTIONS = "handle-degree-subscriptions";

    public function toUrlParameter(): string  {
        return $this->value;
    }
}