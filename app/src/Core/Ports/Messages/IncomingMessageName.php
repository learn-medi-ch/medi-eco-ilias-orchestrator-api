<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;

enum IncomingMessageName: string
{
    case IMPORT_USERS = "import-users";
    case ADDITIONAL_FIELD_VALUE_CHANGED = "additional-field-value-changed";
}