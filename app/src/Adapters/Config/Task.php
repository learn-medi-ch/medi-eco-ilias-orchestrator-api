<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

class Task
{
    private function __construct(
        public object $address,
        public object $messageToDispatch
    ) {

    }

    public static function new(
        object $address,
        object $messageToDispatch
    ) : self {
        return new self(...get_defined_vars());
    }
}