<?php

require_once __DIR__ . "/../autoload.php";

use MediEco\IliasUserOrchestratorOrbital\Adapters\Api\CliApi;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

$cliApi = CliApi::new();

$cliApi->importUsers(Messages\ImportUsers::new(
    ValueObjects\FacultyId::DH,
    ValueObjects\ImportType::FORCE_SUBSCRIPTIONS_UPDATES,
));