<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Api;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Config;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Service;

class CliApi
{

    private function __construct(
        private Config $config
    )
    {

    }

    public static function new(): self
    {
        return new self(
            Config::new()
        );
    }

    public function install(): void
    {
        $service = Service::new();
        $systemRootSpaceNodes = $service->createTree($this->config->rootStructure());

        //debug
        foreach ($systemRootSpaceNodes->spaces() as $systemRootSpaceNode) {
            echo $systemRootSpaceNode->uniqueName() . PHP_EOL;
            foreach ($systemRootSpaceNode->spaces() as $space) {
                echo $space->uniqueName() . PHP_EOL;
                foreach ($space->spaces() as $node) {
                    echo $node->uniqueName() . PHP_EOL;

                    foreach ($node->rooms() as $room) {
                        echo $room->name() . PHP_EOL;
                    }
                }
            }
        }

    }

}