<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class SubscribeStudents implements IncomingMessage
{
    private function __construct(
        public Domain\ValueObjects\FacultyId $facultyId,
        public string $schoolYear,
    ) {

    }

    public static function new(
        Domain\ValueObjects\FacultyId $facultyId,
        string $schoolYear,
    ) : self {
        return new self(...get_defined_vars());
    }

    public function getName() : IncomingMessageName
    {
        return IncomingMessageName::SUBSCRIBE_STUDENTS;
    }
}