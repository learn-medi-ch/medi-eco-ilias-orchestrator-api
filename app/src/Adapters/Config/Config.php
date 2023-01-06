<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Logger;

final readonly class Config
{

    private function __construct(
        public string $name,
        public string $outgoingTasksConfigPath,
        public string $excelImportDirectoryPath,
        public MessageLogger $logger
    ) {

    }

    public static function new() : self
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';
        return new self(
            $name,
            EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_API_CONFIG_PATH->toConfigValue(),
            EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH->toConfigValue(),
            Logger\HttpMessageMessageLogger::new( 'medi-eco-ilias-user-orchestrator-orbital')
        );
    }

    /**
     * @param string $addressPath
     * @return Task[]|null
     */
    public function getOutgoingTasks(string $addressPath) : ?array
    {
        $filePath = $this->outgoingTasksConfigPath . "/outgoing/" . $addressPath . ".json";
        if ($this->fileExists($filePath) === false) {
            $error = new \stdClass();
            $error->title = "FilePath not exists  ";
            $error->data = $filePath;
            $this->logger->log($error,$this->name."/noTaskFound");
            return null;
        }
        $messageConfig = json_decode(file_get_contents($filePath));
        $tasks = [];
        if (property_exists($messageConfig, "tasks")) {
            foreach ($messageConfig->tasks as $task) {
                $tasks[] = Task::new(
                    $task->address,
                    $task->messageToDispatch
                );
            }
        }

        return $tasks;
    }

    private function fileExists(string $url) : bool
    {
        return str_contains(get_headers($url)[0], "200 OK");
    }

}