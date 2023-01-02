<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class Role
{
    private function __construct(
        public FacultyId $facultyId,
        public RoleId $roleId
    ) {

    }

    public static function new(
        FacultyId $facultyId,
        RoleId $roleId
    ) : self {
        return new self($facultyId, $roleId);
    }
}