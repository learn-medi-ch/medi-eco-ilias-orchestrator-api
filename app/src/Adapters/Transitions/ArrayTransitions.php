<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use  MediEco\IliasUserOrchestratorOrbital\Core\Ports\Transitions;

//todo could be in a external library
class ArrayTransitions
{
    private function __construct()
    {

    }

    public static function new()
    {
        return new self();
    }

    /**
     * @throws \Exception
     */
    public function appendIndexedValues(array $value, callable $values): array
    {
        foreach ($values as $index => $valueToAppend) {
            $value[$index] = $valueToAppend;
        }
        return $value;
    }
}