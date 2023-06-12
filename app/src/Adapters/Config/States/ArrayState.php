<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\States;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use Closure;

class ArrayState implements Ports\States\ArrayState
{
    private function __construct(private array|Closure|null $value)
    {

    }

    public static function new(array $value): self
    {
        return new self($value);
    }

    public function value(): array {
        return $this->__invoke();
    }

    public function __invoke(): array
    {
        if (is_callable($this->value)) {
            return call_user_func($this->value);
        }
        return $this->value;
    }

    public function map($fn): ArrayState
    {
        return $this->maybe(fn($value) => array_map(fn($value) => $fn($value), $this->value));
    }


    /**
     * @param $fn
     * @return $this
     */
    public function maybe($fn): ArrayState
    {
        if (is_null($this->value) || (is_array($this->value) && count($this->value) === 0)) {
            return $this;
        }
        return new self($fn($this->value));
    }
}