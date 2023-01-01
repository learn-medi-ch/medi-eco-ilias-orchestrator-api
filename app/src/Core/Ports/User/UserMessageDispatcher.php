<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\User;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface UserMessageDispatcher
{
    public function dispatch(Domain\Messages\OutgoingMessage $message): void;
}