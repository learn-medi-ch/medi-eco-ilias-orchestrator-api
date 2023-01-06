<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Api;
use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Config;
use MediEco\IliasUserOrchestratorOrbital\Adapters;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class CliApi
{
    private $counter = 0;

    private function __construct(
        private Ports\Service $service
    ) {

    }

    public static function new() : self
    {
        $config = Config::new();
        return new self(
            Ports\Service::new(
                Ports\Outbounds::new(
                    Adapters\Repositories\MediExcel\MediExcelUserQueryRepository::new(
                        $config->excelImportDirectoryPath
                    ),
                    Adapters\Dispatchers\HttpMessageDispatcher::new($config)
                )
            )
        );
    }

    public function importUsers(Ports\Messages\ImportUsers $importUsers)
    {
        $this->service->importUsers($importUsers, fn($responseObject) => $this->publish($responseObject));
    }

    public function publish(object|string $responseObject)
    {
        $this->counter = $this->counter + 1;
        $response = $responseObject;
        if (is_string($responseObject === false)) {
            $response = json_encode($responseObject, JSON_PRETTY_PRINT);
        }

        echo $response." ".$this->counter . PHP_EOL;
    }

}