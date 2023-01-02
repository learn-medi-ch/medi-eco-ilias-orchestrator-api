<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;

enum OutgoingMessageName: string {
    case CREATE_OR_UPDATE_USER = "create_or_update_user";
    case ROLE_REMOVED = "role_removed";
    case ROLE_APPENDED = "role_appended";
}