<?php

namespace MediEco\IliasUserOrchestratorApi\Adapters\Config;

enum EnvName: string
{
    case EXCEL_IMPORT_DIRECTORY_PATH = 'EXCEL_IMPORT_DIRECTORY_PATH';
    case HTTP_ENDPOINT_CREATE_OR_UPDATE_USER = 'HTTP_ENDPOINT_CREATE_OR_UPDATE_USER';

    public function toConfigValue(): string|int|array {
        return match($this) {
            EnvName::EXCEL_IMPORT_DIRECTORY_PATH => getenv(EnvName::EXCEL_IMPORT_DIRECTORY_PATH->value),
            EnvName::HTTP_ENDPOINT_CREATE_OR_UPDATE_USER => explode(" ",getenv(EnvName::HTTP_ENDPOINT_CREATE_OR_UPDATE_USER->value))
        };
    }
}