<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use Closure;

class StringValue
{
    private function __construct(private string|Closure|null $value)
    {

    }

    public static function new(string|null $value): self
    {
        return new self($value);
    }

    public function transform($fn): StringValue
    {
        return new self(fn() => $fn($this->value));
    }

    public function __toString(): string
    {
        return $this();
    }

    public function __invoke()
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        return $this->value;
    }


    public function maybe($fn): StringValue
    {
        if ($this->value === null) {
            return $this;
        }
        return new self(fn() => $fn($this->value));
    }
}