<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use Closure;

class ArrayValue
{
    private function __construct(private array|Closure|null $value)
    {

    }

    public static function new(array|null $value): self
    {
        return new self($value);
    }

    public function __invoke()
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        return $this->value;
    }

    public function map($fn): ArrayValue
    {
        return new self(fn() => array_map(fn($value) => $fn($value), $this->value));
    }


    public function maybe($fn): ArrayValue
    {
        if (is_null($this->value) | is_array($this->value) && count($this->value) === 0) {
            return $this;
        }
        return new self(fn() => $fn($this->value));
    }
}