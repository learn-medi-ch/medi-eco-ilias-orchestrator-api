<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\StringValue;

/**
 * @method string name()
 * @method string uniqueName()
 */
final readonly class UserGroup
{
    private function __construct(
        public StringValue $uniqueName,
        public StringValue $label
    )
    {

    }

    public function __call($method, $args)
    {
        if (is_callable(array($this, $method))) {
            return call_user_func_array($this->$method, $args);
        }
    }

    public static function new(
        StringValue $uniqueName,
        StringValue $label
    ): self
    {
        return new self(...get_defined_vars());
    }

}
