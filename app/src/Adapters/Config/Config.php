<?php

namespace MediEco\IliasUserOrchestratorApi\Adapters\Config;

class Config
{

    private function __construct(
        public readonly string $excelImportDirectoryPath,
        public readonly array $httpEndpointsCreateOrUpdateUser
    ) {

    }

    public static function new() : self
    {
        return new self(
           EnvName::EXCEL_IMPORT_DIRECTORY_PATH->toConfigValue(),
           EnvName::HTTP_ENDPOINT_CREATE_OR_UPDATE_USER->toConfigValue(),
        );
    }

}