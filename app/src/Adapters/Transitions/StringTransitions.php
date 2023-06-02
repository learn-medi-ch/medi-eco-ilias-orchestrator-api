<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Transitions;

//todo could be in a external library
class StringTransitions
{
    private function __construct()
    {

    }

    public static function new(): self
    {
        return new self();
    }


    public function spaceToKebabCase(string $value): string
    {
        return implode("-", explode(" ", $value));
    }
}