<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Ports\Task;

enum TaskName: string
{
    case IMPORT_USERS = "import-users";
    case ADDITIONAL_FIELD_VALUE_ADDED = "additional-field-value-added";
    case ADDITIONAL_FIELD_VALUE_CHANGED = "additional-field-value-changed";
    case ADDITIONAL_FIELD_VALUE_REMOVED = "additional-field-value-removed";
}