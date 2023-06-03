<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ArrayValue;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\StringValue;

/**
 * @method string name()
 * @method string uniqueName()
 * @method SpaceNode[] spaces()
 * @method RoomNode[] rooms()
 * @method RoleNode[] roles()
 */
final readonly class SpaceNode
{
    private function __construct(
        public StringValue $name,
        public StringValue $uniqueName,
        public ArrayValue $spaces,
        public ArrayValue $rooms,
        public ArrayValue $roles,
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
        StringValue $name,
        StringValue $uniqueName,
        ArrayValue $spaces,
        ArrayValue $rooms,
        ArrayValue $roles,
    ): self
    {
        return new self(...get_defined_vars());
    }
}