<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Dispatchers;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Config;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;
use stdClass;

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

    public function dispatch(Domain\Messages\OutgoingMessage $message) : void
    {
        $this->config->logger->log($message, $message->getAddress());

        $tasks = $this->config->getOutgoingTasks(str_replace(" ", "%20", $message->getAddress()));
        if ($tasks === null) {
            return;
        }

        foreach ($tasks as $task) {
            if (str_contains($task->address->server->protocol, "http") === false) {
                continue;
            }

            if (property_exists($task, 'required') === true) {
                $abort = false;
                foreach ($task->required as $required) {
                    if (str_contains($required, '{$message.') === true) {
                        $propertyName = rtrim(ltrim($required, '{$message.'), '}');
                        if (property_exists($message,
                                $propertyName) === false || $message->{$propertyName} === null || $message->{$propertyName} === "") {
                            $abort = true;
                        }
                    }
                }
                if ($abort === true) {
                    continue;
                }
            }

            $addressPath = $task->address->path;
            if ($task->address->parameters !== null) {
                foreach ((array) $task->address->parameters as $parameterName => $parameter) {
                    $addressPath = $this->replaceParameter($addressPath, $parameterName, $parameter, $message);
                }
            }


            $messageToDispatch = $task->messageToDispatch;

            if (property_exists($messageToDispatch, '$merge') === true) {
                if (str_contains($messageToDispatch->{'$merge'}, '{$message}') === true) {
                    unset($messageToDispatch->{'$merge'});
                    $messageToDispatch = (object) array_merge(
                        (array) $messageToDispatch, (array) $message);
                }
            }

            if (property_exists($messageToDispatch, '$location') === true) {
                if (str_contains($messageToDispatch->{'$location'}, '{$message}') === true) {
                    $messageToDispatch = $message;
                }
            }

            if (property_exists($messageToDispatch, '$transform') === true) {
                $properties = $messageToDispatch->{'$transform'};
                $messageToDispatch = new stdClass();
                foreach ($properties as $propertyKey => $propertyValue) {
                    if (str_contains($propertyValue, '{$message.') === true) {
                        $messagePropertyKey = rtrim(ltrim($propertyValue, '{$message.'), '}');
                        $propertyValue = $message->{$messagePropertyKey};
                    }
                    $messageToDispatch->{$propertyKey} = $propertyValue;
                }
            }

            $this->config->logger->log($messageToDispatch, $addressPath);

            $this->publish($messageToDispatch,
                $task->address->server->protocol . "://" . $task->address->server->url . "/" . $addressPath);

        }
    }

    private function replaceParameter(string $address, string $parameterName, object $parameter, Domain\Messages\OutgoingMessage $message): string {
        if(str_contains($parameter->location, '{$message}') === true)  {
            $location = ltrim($parameter->location, '{$message}');
            $messageAttributePath =  explode('/', $location);
            $value = $message;
            foreach($messageAttributePath as $attributeName) {
                $value = $value->{$attributeName};
            }
            $address = str_replace('{'.$parameterName.'}', $value, $address);
        }
        return $address;
    }


    private function publish(object $payload, string $address) : void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $address);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'x-eco-orbital: '.$this->config->name]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}