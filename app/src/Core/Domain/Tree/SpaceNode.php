<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Tree;


final readonly class SpaceNode implements SpaceElement
{

    private function __construct(
        public string $uniqueName,
        public string $label,
        public object $spaces,
        public object $rooms,
        public object $roles,
        public object $userGroups
    )
    {

    }

    /**
     * @param string $uniqueName
     * @param string $label
     * @param object $spaces
     * @param object $rooms
     * @param object $userGroups
     * @param object $roles
     * @return static  //todo
     */
    public static function new(
        string $uniqueName,
        string $label,
        object $spaces = new \stdClass(),
        object $rooms = new \stdClass(),
        object $userGroups = new \stdClass(),
        object $roles = new \stdClass()
    ): self
    {
        return new self(...get_defined_vars());
    }
}