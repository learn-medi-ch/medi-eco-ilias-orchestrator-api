<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Domain\Messages;

interface Message {
    public function getName(): MessageName;
}