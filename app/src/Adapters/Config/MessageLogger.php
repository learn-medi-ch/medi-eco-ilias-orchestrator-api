<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;
interface MessageLogger {
    public function log(object $payload, string $address): void;
}