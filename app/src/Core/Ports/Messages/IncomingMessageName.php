<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;

enum IncomingMessageName: string
{
    case IMPORT_USERS = "import-users";
    case HANDLE_SUBSCRIPTIONS = "handle-subscriptions";
}