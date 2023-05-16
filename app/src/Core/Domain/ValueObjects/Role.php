<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class Role
{
    private function __construct(
        public FacultyId $facultyId,
        public RoleIdSuffix $roleId
    ) {

    }

    public static function new(
        FacultyId $facultyId,
        RoleIdSuffix $roleId
    ) : self {
        return new self($facultyId, $roleId);
    }
}