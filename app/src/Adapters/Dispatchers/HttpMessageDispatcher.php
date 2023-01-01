<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Dispatchers;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Config;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

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

    public function dispatch(Domain\Messages\OutgoingMessage $message): void
    {
        $tasks = $this->config->getOutgoingTasks($message->getAddress());
        if($tasks === null) {
            return;
        }
        foreach($tasks as $task) {
            $address = $task->address;
            if($task->parameters !== null) {
                foreach($task->parameters as $parameterName => $parameter) {
                    $address = $this->replaceParameter($address, $parameterName, $parameter, $message);
                }
            }
            $payload = $task->message->payload;
            if(property_exists($payload, 'location') === true) {
                if(str_contains('$message.payload#', $payload->location) === true) {
                    $payload = $message;
                }
            }
            $this->publish($payload, $task->server."/".$address);
        }
    }


    private function replaceParameter(string $address, string $parameterName, object $parameter, Domain\Messages\OutgoingMessage $message): string {
        print_r($parameter);
        if(str_contains($parameter->location, '$message.payload#') === true)  {
            $location = ltrim($parameter->location, '$message.payload#/');
            $messageAttributePath =  explode('/', $location);
            print_r($messageAttributePath);
            $value = $message;
            foreach($messageAttributePath as $attributeName) {
                $value = $value->{$attributeName};
            }
            $address = str_replace('{'.$parameterName.'}', $value, $address);
        }
        echo $address;
        return $address;
    }


    private function publish(object $payload, string $address) : void
    {
        echo $address.PHP_EOL;
        $ch = curl_init();
        $responses = [];
        curl_setopt($ch, CURLOPT_URL, $address);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responses[] = curl_exec($ch);
        print_r($responses);
        curl_close($ch);
    }
}