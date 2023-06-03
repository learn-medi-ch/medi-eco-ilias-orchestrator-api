<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use Closure;
use stdClass;

class ObjectValue
{
    private function __construct(private stdClass|Closure $value)
    {

    }


    public static function new(object|null $value): self
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

    public function transform($fn): ObjectValue
    {
        return new self(fn() => $fn($this->value));
    }

    public function merge($fn): ObjectValue
    {
        return new self(fn() => (object)array_merge((array)$this->value, (array)$fn));
    }

    public function maybe($fn): ObjectValue
    {
        if ($this->value === null) {
            return $this;
        }
        return new self(fn() => $fn($this->value));
    }
}