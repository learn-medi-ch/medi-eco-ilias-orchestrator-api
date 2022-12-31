<?php

namespace MediEco\IliasUserOrchestratorApi\Adapters\Dispatchers;

use MediEco\IliasUserOrchestratorApi\Adapters\Config;
use MediEco\IliasUserOrchestratorApi\Core\Ports;
use MediEco\IliasUserOrchestratorApi\Core\Domain;

class HttpMessageDispatcher implements Ports\User\UserMessageDispatcher
{

    private function __construct(
        public readonly Config\Config $config
    ) {

    }

    public static function new(
        Config\Config $config
    ) : self {
        return new self($config);
    }

    public function dispatch(Domain\Messages\Message $message): void
    {
        match ($message->getName()) {
            Domain\Messages\MessageName::CREATE_OR_UPDATE_USER => $this->publish($message,
                $this->config->httpEndpointsCreateOrUpdateUser)
        };
    }

    private function publish(Domain\Messages\Message $message, array $endpoints) : void
    {
        $ch = curl_init();
        $responses = [];
        foreach ($endpoints as $endpoint) {
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responses[] = curl_exec($ch);
            curl_close($ch);
        }
    }
}