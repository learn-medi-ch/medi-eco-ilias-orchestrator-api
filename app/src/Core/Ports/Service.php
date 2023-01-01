<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use  MediEco\IliasUserOrchestratorOrbital\Core\Domain;

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

    public function onAdditionalFieldValueAdded(Messages\AdditionalFieldValueChanged $message, callable $publish)  {

        match($message->additionalFieldName) {
             Domain\ValueObjects\MediAdditionalFieldName::BG_BERUFSBILDE->value => $this->handleSubscriptions($message->userId, $message->newAdditionalFieldValue, $message->oldAdditionalFieldValue, Domain\ValueObjects\MediRoleId::FACULTY_VOCATIONAL_TRAINER, $publish)
        };
    }

    private function handleSubscriptions(string $userId, ?string $newValue, ?string $oldValue, Domain\ValueObjects\MediRoleId $roleId, callable $publish) {
        $aggregate = Domain\UserAggregate::new(Domain\ValueObjects\UserId::new($userId));
        if($newValue === null)  {
            $oldFacultyIds = array_map('trim', explode(',', $oldValue));
            foreach($oldFacultyIds as $facultyId) {
                $aggregate->removeRole(Domain\ValueObjects\MediRole::new(Domain\ValueObjects\MediFacultyId::from($facultyId),$roleId));
            }
        }
        if($newValue !== null)  {
            $oldFacultyIds = array_map('trim', explode(',', $oldValue));
            $newFacultyIds = array_map('trim', explode(',', $newValue));
            foreach($newFacultyIds as $facultyId) {
                if(in_array($facultyId, $oldFacultyIds) === false) {
                    $aggregate->appendRole(Domain\ValueObjects\MediRole::new(Domain\ValueObjects\MediFacultyId::from($facultyId),$roleId));
                }
            }
        }
        $this->dispatchMessages($aggregate->getAndResetRecordedMessages(), $publish);
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