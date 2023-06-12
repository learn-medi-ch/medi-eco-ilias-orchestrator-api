<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\States;

interface ArrayState
{

    public function map($fn): self;

    /**
     * @param $fn
     * @return $this
     */
    public function maybe($fn): self;

    public function __invoke(): array;
    public function value(): array;
}