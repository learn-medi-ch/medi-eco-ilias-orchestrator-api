<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\States;

interface Service {
    public function newStringState(string $string): StringState;

    public function newPathState(array $segments): PathState;

    public function newObjectState(object $object): ObjectState;

    public function newArrayState(array $string): ArrayState;
}

