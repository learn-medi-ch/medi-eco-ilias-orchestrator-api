<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class MediRole
{
    private function __construct(
        public MediFacultyId $facultyId,
        public MediRoleId $roleId
    ) {

    }

    public static function new(
        MediFacultyId $facultyId,
        MediRoleId $roleId
    ) : self {
        return new self($facultyId, $roleId);
    }
}