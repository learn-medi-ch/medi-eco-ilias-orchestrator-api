<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;

interface IncomingMessage {
    public function getName(): IncomingMessageName;
}