<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

//todo move those values to a separate service
class Value
{
    private function __construct()
    {

    }

    public static function new(): self
    {
        return new self();
    }

    public function string(string $string): StringValue
    {
        return StringValue::new($string);
    }

    public function path(array $segments): PathValue
    {
        return PathValue::fromArray($segments);
    }

    public function object(object $object): ObjectValue
    {
        return ObjectValue::new($object);
    }

    public function array(array $string): ArrayValue
    {
        return ArrayValue::new($string);
    }
}