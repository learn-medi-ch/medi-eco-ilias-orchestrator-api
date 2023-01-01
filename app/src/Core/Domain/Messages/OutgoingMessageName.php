<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;

enum OutgoingMessageName: string {
    case CREATE_OR_UPDATE_USER = "create_or_update_user";
    case MEDI_ROLE_REMOVED = "medi_role_removed";
    case MEDI_ROLE_APPENDED = "medi_role_appended";
}