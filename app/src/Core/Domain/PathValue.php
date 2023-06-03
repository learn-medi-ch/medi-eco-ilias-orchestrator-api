<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use Closure;

class PathValue
{
    private function __construct(private string|Closure|null $value)
    {

    }

    public static function fromArray(array $segments)
    {
        return new self(implode("-", array_filter($segments)));
    }

    public static function new(string|null $value): self
    {
        return new self($value);
    }

    public function transform($fn): PathValue
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


    public function maybe($fn): PathValue
    {
        if ($this->value === null) {
            return $this;
        }
        return new self(fn() => $fn($this->value));
    }
}