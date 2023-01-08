<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Logger;

final readonly class Config
{

    private function __construct(
        public string $name,
        public string $excelImportDirectoryPath
    ) {

    }

    public static function new() : self
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';
        return new self(
            $name,
            EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH->toConfigValue()
        );
    }

}