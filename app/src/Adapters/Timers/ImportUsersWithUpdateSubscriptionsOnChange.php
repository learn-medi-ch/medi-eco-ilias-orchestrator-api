<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Timers;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\FacultyId;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\ImportType;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\Messages\IncomingMessageName;
use Swoole\Timer;

use function Swoole\Coroutine\run;

class ImportUsersWithUpdateSubscriptionsOnChange
{
    private function __construct(
        public int $frequencyInMs
    ) {

    }

    public static function new(int $frequencyInMs) {
        return new self($frequencyInMs);
    }

    public function run()
    {
        //every hour
        Timer::tick($this->frequencyInMs, function () {
            foreach(FacultyId::cases() as $facultyId) {
                $this->runFacultyImport($facultyId);
            }
        });
    }

    public function runFacultyImport(FacultyId $facultyId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:9501/".$facultyId->toUrlParameter()."/".ImportType::UPDATE_SUBSCRIPTIONS_ON_CHANGE->toUrlParameter()."/".IncomingMessageName::IMPORT_USERS->toUrlParameter());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responses[] = curl_exec($ch);
        print_r($responses);
        curl_close($ch);
    }
}

