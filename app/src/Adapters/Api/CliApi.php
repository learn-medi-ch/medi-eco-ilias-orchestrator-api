<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Api;

use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Config;
use MediEco\IliasUserOrchestratorOrbital\Adapters;
use MediEco\IliasUserOrchestratorOrbital\Core\{Ports,Domain};

class CliApi
{
    private $counter = 0;
    private Config $config;

    private function __construct(
        private Ports\Service $service
    )
    {

    }

    public static function new(): self
    {
        $iliasRestApiClient = IliasRestApiClient::new();
        return new self(
            Ports\Service::new(
                Config::new()
            ),
        );
    }

    public function install(): void
    {
        $this->service->createOrUpdateSpaceTrees($this->config->readSystemRootSpaceNode(System\Settings:: )
        /*$this->service->createMediGeneralCategories();
        $this->service->createMediFacultiesCategories();
        $this->service->createMediGeneralRoles();
        $this->service->createMediFacultiesRoles();*/
    }

    public function importUsers(Ports\Messages\ImportUsers $importUsers): void
    {
        $this->service->importUsers($importUsers, fn($responseObject) => $this->publish($responseObject));
    }

    public function publish(object|string $responseObject): void
    {
        $this->counter = $this->counter + 1;
        $response = $responseObject;
        if (is_string($responseObject) === false) {
            $response = json_encode($responseObject, JSON_PRETTY_PRINT);
        }

        echo $response . " " . $this->counter . PHP_EOL;
    }

}