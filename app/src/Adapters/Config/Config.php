<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

class Config
{

    private function __construct(
        public readonly string $outgoingTasksConfigPath,
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
     * @param string $addressPath
     * @return Task[]|null
     */
    public function getOutgoingTasks(string $addressPath) : ?array
    {
        $filePath = $this->outgoingTasksConfigPath . "/outgoing/" . $addressPath . ".json";
        if ($this->fileExists($filePath) === false) {
            echo "FilePath not exists  " . $filePath . PHP_EOL;
            return null;
        }
        $messageConfig = json_decode(file_get_contents($filePath));
        print_r($messageConfig);
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