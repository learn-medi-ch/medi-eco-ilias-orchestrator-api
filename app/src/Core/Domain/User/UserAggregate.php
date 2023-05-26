<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class UserAggregate
{
    private array $recordedMessages = [];
    public ?ValueObjects\MediStudentData $userData = null;
    public array $additionalFields = [];

    private function __construct(
        private ValueObjects\MediUserImportId $userId
    ) {

    }

    /**
     * @return static
     */
    public static function new(
        ValueObjects\MediUserImportId $userId
    ) : self {
        return new self($userId);
    }

    private function recordMessage(Messages\OutgoingMessage $message) : void
    {
        $this->recordedMessages[] = $message;
    }

    public function getAndResetRecordedMessages() : array
    {
        $messages = $this->recordedMessages;
        $this->recordedMessages = [];
        return $messages;
    }

    /**
     * @param ValueObjects\AdditionalField[] $additionalFields
     * @return void
     */
    public function createOrUpdateUser(
        ValueObjects\MediStudentData $userData,
        array                        $additionalFields
    ) : void {
        $createOrUpdateUser = Messages\CreateOrUpdateUser::new($this->userId, $userData, $additionalFields);
        $this->applyCreateOrUpdateUser($createOrUpdateUser);
        $this->recordMessage($createOrUpdateUser);
    }

    private function applyCreateOrUpdateUser(Messages\CreateOrUpdateUser $createOrUpdateUser)
    {
        $this->userData = $createOrUpdateUser->userData;
        $this->additionalFields = $createOrUpdateUser->additionalFields;
    }

    /**
     * @return void
     */
    public function removeRole(
        ValueObjects\MediRole $mediRole
    ) : void {
        $this->recordMessage(Messages\RoleRemoved::new($this->userId, $mediRole));
    }

    /**
     * @return void
     */
    public function appendRole(
        ValueObjects\MediRole $mediRole
    ) : void {
        $this->recordMessage(Messages\RoleAppended::new($this->userId, $mediRole));
    }

}