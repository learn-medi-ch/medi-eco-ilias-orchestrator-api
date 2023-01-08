<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

enum EnvName: string
{
    case MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH = 'MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH';
    case MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_DISPATCHER_CONFIG_ARCHIVE_PATH = 'MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_DISPATCHER_CONFIG_ARCHIVE_PATH';

    public function toConfigValue() : string|int|array
    {
        return getenv($this->value);
    }
}