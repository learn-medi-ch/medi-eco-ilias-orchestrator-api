<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class ImportUsers implements IncomingMessage
{
    private function __construct(
        public Domain\ValueObjects\FacultyId $facultyId,
        public Domain\ValueObjects\ImportType $importType,
    ) {

    }

    public static function new(
        Domain\ValueObjects\FacultyId $facultyId,
        Domain\ValueObjects\ImportType $importType,
    ) : self {
        return new self(...get_defined_vars());
    }

    public function getName() : IncomingMessageName
    {
        return IncomingMessageName::IMPORT_USERS;
    }
}