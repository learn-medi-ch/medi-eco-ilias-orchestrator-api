<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Messages;

interface OutgoingMessage {
    public function getName(): OutgoingMessageName;
    public function getAddress(): string;
}