<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Api;

use client\src\Adapter\Api\IliasRestApiClient;
use mysql_xdevapi\Exception;
use Swoole\Http;
use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Config;
use MediEco\IliasUserOrchestratorOrbital\Adapters;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

class HttpApi
{
    private function __construct(
        private Ports\Service                             $service,
        private client\src\Adapter\Api\IliasRestApiClient $iliasRestApiClient,
    )
    {

    }

    public static function new(): self
    {
        $config = Config::new();

        $iliasRestApiClient =  client\src\Adapter\Api\IliasRestApiClient::new();

        return new self(
            Ports\Service::new(
                Ports\Outbounds::new(
                    $iliasRestApiClient,
                    Adapters\Repositories\MediExcel\MediExcelUserQueryRepository::new(
                        $config->excelImportDirectoryPath
                    ),
                    Adapters\Dispatchers\HttpMessageDispatcher::new($config)
                )
            ),
            client\src\Adapter\Api\IliasRestApiClient::new()
        );
    }

    /**
     * @throws \Exception
     */
    final public function handleHttpRequest(Http\Request $request, Http\Response $response): void
    {
        $requestUri = $request->server['request_uri'];

        $currentIliasUserId = $request->header['x-flux-ilias-rest-api-user-id'];

        //x-flux-ilias-rest-api-user-id

        $rolesOfCurrentUser = $this->iliasRestApiClient->getUserRoles($currentIliasUserId);
        $isAdmin = false;
        foreach ($rolesOfCurrentUser as $role) {
            if ($role->role_id === 2) {
                $isAdmin = true;
            }
        }
        if ($isAdmin === false) {
            throw new Exception("user is not admin");
            exit;
        }

        match (true) {
            str_ends_with(
                $requestUri,
                Ports\Messages\IncomingMessageName::HANDLE_SUBSCRIPTIONS->value
            ) => $this->service->handleSubscriptions(
                Ports\Messages\HandleSubscriptions::fromJson(
                    $request->rawContent()
                ),
                $this->publish($response)
            ),
            str_ends_with(
                $requestUri,
                Ports\Messages\IncomingMessageName::IMPORT_USERS->value
            ) => $this->service->importUsers(
                Ports\Messages\ImportUsers::new(
                    ValueObjects\FacultyId::from($request->get['facultyId']),
                    ValueObjects\ImportType::FORCE_SUBSCRIPTIONS_UPDATES,
                ),
                $this->publish($response)
            ),
            str_ends_with(
                $requestUri,
                Ports\Messages\IncomingMessageName::SUBSCRIBE_STUDENTS->value
            ) => $this->service->subscribeStudents(
                Ports\Messages\SubscribeStudents::new(
                    ValueObjects\FacultyId::from($request->get['facultyId']),
                    $request->get['schoolYear'],
                ),
                $this->publish($response)
            ),
            default => $this->publish($response)("endpoint does not exist: " . $requestUri)
        };
    }

    private function publish(Http\Response $response): \Closure
    {
        return function (object|string $responseObject) use ($response) {

            if (is_object($responseObject) && property_exists($responseObject,
                    'cookies') && count($responseObject->cookies) > 0) {
                foreach ($responseObject->cookies as $name => $value) {
                    $response->setCookie($name, $value, time() + 3600);
                }
            }

            $response->header('Content-Type', 'application/json');
            $response->header('Cache-Control', 'no-cache');

            match (true) {
                is_string($responseObject) => $response->end($responseObject),
                default => $response->end(json_encode($responseObject))
            };
        };
    }

    private function getAttributeFromUrl(string $attributeName, string $requestUri): string
    {
        $explodedParam = explode($attributeName . "/", $requestUri, 2);
        if (count($explodedParam) === 2) {
            $explodedParts = explode("/", $explodedParam[1], 2);
            if (count($explodedParts) == 2) {
                return $explodedParts[0];
            }
            return $explodedParam[1];
        }
    }
}