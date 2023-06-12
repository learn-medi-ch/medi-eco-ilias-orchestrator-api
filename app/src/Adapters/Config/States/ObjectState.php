<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\States;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use Closure;
use stdClass;

class ObjectState implements Ports\States\ObjectState
{
    private function __construct(private stdClass|Closure $value)
    {

    }


    public static function new(object|null $value): self
    {
        return new self($value);
    }

    public function __invoke(): object
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        $state = $this->maybe(fn($value) => $value); //todo check
        return $state->value;
    }

    public function transform($fn): ObjectState
    {
        return new self(fn() => $fn($this->value));
    }

    public function merge($fn): ObjectState
    {
        return new self(fn() => (object)array_merge((array)$this->value, (array)$fn));
    }

    public function maybe($fn): ObjectState
    {
        if ($this->value === null) {
            return new self(new stdClass());
        }
        return new self(fn() => $fn($this->value));
    }
}