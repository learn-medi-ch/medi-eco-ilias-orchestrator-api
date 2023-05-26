<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum ImportType: string {
    case UPDATE_SUBSCRIPTIONS_ON_CHANGE = "update-subscriptions-on-change";
    case FORCE_SUBSCRIPTIONS_UPDATES = "force-subscriptions-updates";

    public function toUrlParameter(): string  {
        return "import-type/".$this->value;
    }
}