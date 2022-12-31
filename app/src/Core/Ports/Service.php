<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Ports;

use  MediEco\IliasUserOrchestratorApi\Core\Domain;

class Service
{

    private function __construct(
        private Outbounds $outbounds
    ) {

    }

    public static function new(Outbounds $outbounds)
    {
        return new self($outbounds);
    }

    public function importUsers(string $contextId, callable $publish)
    {
        $usersToHandle = $this->outbounds->userQueryRepository->getFacultyUsers($contextId);
        $recordedMessages = [];
        foreach ($usersToHandle as $user) {
            $aggregate = Domain\UserAggregate::new($user->userId);
            $aggregate->createOrUpdateUser($user->userData, $user->additionalFields);
            $recordedMessages = array_merge($recordedMessages, $aggregate->getAndResetRecordedMessages());
        }
        $this->dispatchMessages($recordedMessages, $publish);
    }

    private function dispatchMessages(array $recordedMessages, callable $publish) {
        $handledMessages = [];
        if (count($recordedMessages) > 0) {
            foreach ($recordedMessages as $message) {
                $this->outbounds->userMessageDispatcher->dispatch($message);
                $handledMessages[] = $message;
            }
        }
        $publish(json_encode($handledMessages, JSON_PRETTY_PRINT));
    }

}