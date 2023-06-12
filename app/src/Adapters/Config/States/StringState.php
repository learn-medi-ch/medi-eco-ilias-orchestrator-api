<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\States;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use Closure;

class StringState implements Ports\States\StringState
{
    private function __construct(private string|Closure|null $value)
    {

    }

    public static function new(string|null $value): self
    {
        return new self($value);
    }

    public function transform($fn): StringState
    {
        return new self(fn() => $fn($this->value));
    }

    public function __toString(): string
    {
        return $this();
    }

    public function __invoke(): string
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        return $this->value;
    }


    public function maybe($fn): StringState
    {
        if ($this->value === null) {
            return $this;
        }
        return new self(fn() => $fn($this->value));
    }
}