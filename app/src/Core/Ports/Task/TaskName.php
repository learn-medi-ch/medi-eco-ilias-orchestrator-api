<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Task;

enum TaskName: string
{
    case IMPORT_USERS = "import-users";
    case ON_ADDITIONAL_FIELD_VALUE_ADDED = "on-additional-field-value-added";
    case ON_ADDITIONAL_FIELD_VALUE_CHANGED = "on-additional-field-value-changed";
    case ON_ADDITIONAL_FIELD_VALUE_REMOVED = "on-additional-field-value-removed";
}