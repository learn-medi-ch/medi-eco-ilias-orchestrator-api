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

    public function importUsers(Messages\ImportUsers $message, callable $publish)
    {
        $usersToHandle = $this->outbounds->userQueryRepository->getFacultyUsers($message->facultyId->value);
        $recordedMessages = [];
        foreach ($usersToHandle as $user) {
            $aggregate = Domain\UserAggregate::new($user->userId);
            $aggregate->createOrUpdateUser($user->userData, array_values($user->additionalFields));
            $recordedMessages = array_merge($recordedMessages, $aggregate->getAndResetRecordedMessages());
        }
        $this->dispatchMessages($recordedMessages);

        if ($message->importType === Domain\ValueObjects\ImportType::FORCE_SUBSCRIPTIONS_UPDATES) {
            foreach ($usersToHandle as $user) {
                foreach (Domain\ValueObjects\RoleId::cases() as $roleId) {
                    $this->handleSubscriptions(
                        Messages\HandleSubscriptions::new(
                            $user->userId,
                            $roleId->toFieldName(),
                            $user->additionalFields[$roleId->toFieldName()]->fieldValue,
                            Domain\ValueObjects\FacultyId::asCommaSeparatedString(),
                            $roleId
                        ),
                        $publish
                    );
                }
            }
        }
    }

    public function handleSubscriptions(
        Messages\HandleSubscriptions $message,
        callable $publish
    ) {
        $aggregate = Domain\UserAggregate::new($message->userId);
        if ($message->newAdditionalFieldValue === "" || $message->newAdditionalFieldValue === null) {
            $oldFacultyIds = array_map('trim', explode(',', $message->oldAdditionalFieldValue));
            foreach ($oldFacultyIds as $facultyId) {
                $aggregate->removeRole(Domain\ValueObjects\Role::new(Domain\ValueObjects\FacultyId::from($facultyId),
                    $message->roleId));
            }
        } else {
            $oldFacultyIds = array_map('trim', explode(',', $message->oldAdditionalFieldValue));
            $newFacultyIds = array_map('trim', explode(',', $message->newAdditionalFieldValue));
            foreach ($newFacultyIds as $facultyId) {
                $aggregate->appendRole(Domain\ValueObjects\Role::new(Domain\ValueObjects\FacultyId::from($facultyId),
                    $message->roleId));
            }
            foreach ($oldFacultyIds as $facultyId) {
                if ($facultyId === "") {
                    continue;
                }
                if (in_array($facultyId, $newFacultyIds) === false) {
                    $aggregate->removeRole(Domain\ValueObjects\Role::new(Domain\ValueObjects\FacultyId::from($facultyId),
                        $message->roleId));
                }
            }
        }
        $this->dispatchMessages($aggregate->getAndResetRecordedMessages());

        $publish("Ok: " . $message->getName()->toUrlParameter());
    }

    private function dispatchMessages(array $recordedMessages)
    {
        if (count($recordedMessages) > 0) {
            foreach ($recordedMessages as $message) {
                $this->outbounds->userMessageDispatcher->dispatch($message);
            }
        }
    }

}