<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\States;


use Closure;

interface PathState
{
    public function transform($fn): self;

    public function __toString(): string;

    public function maybe($fn): self;

    public function __invoke(): string;

}