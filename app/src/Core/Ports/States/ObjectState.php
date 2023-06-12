<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\States;

interface ObjectState
{

    public function transform($fn): self;

    public function merge($fn): self;

    public function maybe($fn): self;

    public function __invoke(): object;

}