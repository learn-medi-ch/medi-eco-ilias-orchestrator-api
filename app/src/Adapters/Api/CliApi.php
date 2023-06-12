<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Api;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Config;
use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms\LanguageType;

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
            Config::new(LanguageType::DE)
        );
    }

    public function install(): void
    {
        $service = Ports\Service::new($this->config->lmsService(), $this->config->stateService());
        $service->createOrUpdateTree($this->config->lmsRootSpace());
    }

    public function createNewClasses(): void {

    }


    private function createNewClasseAndCorrespondingCurriculum(
        string          $className,
        Ports\Lms\Space $curriculumSpace
    ): void
    {

    }


}