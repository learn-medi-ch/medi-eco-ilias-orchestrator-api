<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\AddressParameter;

enum ImportType: string {
    case UPDATE_SUBSCRIPTIONS_ON_CHANGE = "update_subscriptions_on_change";
    case FORCE_SUBSCRIPTIONS_UPDATES = "force_subscriptions_updates";
}