<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

enum EnvName: string
{
    case MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH = 'MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH';
    case MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_API_CONFIG_PATH = 'MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_API_CONFIG_PATH';

    public function toConfigValue() : string|int|array
    {
        return getenv($this->value);
    }
}