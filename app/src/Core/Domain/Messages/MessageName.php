<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Domain\Messages;

enum MessageName: string {
    case CREATE_OR_UPDATE_USER = "create_or_update_user";
}