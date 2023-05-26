<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label\{Dictionary};

interface Config
{
    public function dictionary(): Dictionary;
}