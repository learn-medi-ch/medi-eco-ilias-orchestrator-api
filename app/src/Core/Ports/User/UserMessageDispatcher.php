<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Ports\User;

use MediEco\IliasUserOrchestratorApi\Core\Domain;

interface UserMessageDispatcher
{
    public function dispatch(Domain\Messages\Message $message): void;
}