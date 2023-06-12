<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\States;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class Service implements Ports\States\Service
{

    private function __construct()
    {

    }

    public static function new()
    {
        return new self();
    }

    public function newStringState(string $string): StringState
    {
        return StringState::new($string);
    }

    public function newPathState(array $segments): PathState
    {
        return PathState::fromArray($segments);
    }

    public function newObjectState(object $object): ObjectState
    {
        return ObjectState::new($object);
    }

    public function newArrayState(array $string): ArrayState
    {
        return ArrayState::new($string);
    }

}



