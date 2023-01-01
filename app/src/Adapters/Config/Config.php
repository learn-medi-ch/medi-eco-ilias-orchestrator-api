<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class Config
{

    private function __construct(
        public readonly string $apiConfigUrl,
        public readonly string $excelImportDirectoryPath,
    ) {

    }

    public static function new() : self
    {
        return new self(
           EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_API_CONFIG_PATH->toConfigValue(),
           EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH->toConfigValue(),
        );
    }

    /**
     * @param string $address
     * @return Task[]|null
     */
    public function getOutgoingTasks(string $address): ?array {
        $filePath = $this->apiConfigUrl."/outgoing/".$address.".json";
        if($this->fileExists($filePath) === false) {
            echo "FilePath not exists  ".$filePath.PHP_EOL;
            return null;
        }
        $messageConfig = json_decode(file_get_contents($filePath));
        $tasks = [];
        if(property_exists($messageConfig, "tasks")) {
            foreach($messageConfig->tasks as $task) {
                $tasks[] = Task::new(
                    $task->server,
                    $task->address,
                    $task->parameters,
                    $task->message
                );
            }
        }

        return $tasks;
    }


    private function fileExists(string $url): bool
    {
        return str_contains(get_headers($url)[0], "200 OK");
    }

    public function getOutgoingAddresses(Domain\Messages\OutgoingMessageName $messageName): ?array {
        /*
        //$apiDefinition = json_decode(file_get_contents(EnvName::FLUX_ECO_ILIAS_USER_ORBITAL_API_FILE->toConfigValue()));

        $outgoingMessages = $apiDefinition->messages->outgoing;

        if(property_exists($outgoingMessages, $messageName->value) === false) {
            return null;
        }

        $messageDefinition = $outgoingMessages->{$messageName->value};
        $servers = $messageDefinition->servers;
        $addresses = [];
        foreach($servers as $server) {
            $addresses[] = $server->url."/".$messageDefinition->address;
        }
        return $addresses;
        */
    }

}