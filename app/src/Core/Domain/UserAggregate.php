<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class UserAggregate
{
    private array $recordedMessages = [];
    public ?ValueObjects\UserData $userData = null;
    public array $additionalFields = [];

    private function __construct(
        private ValueObjects\UserId $userId
    ) {

    }

    /**
     * @return static
     */
    public static function new(
        ValueObjects\UserId $userId
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
        ValueObjects\UserData $userData,
        array $additionalFields
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
        $this->recordMessage(Messages\MediRoleRemoved::new($this->userId, $mediRole));
    }

    /**
     * @return void
     */
    public function appendRole(
        ValueObjects\MediRole $mediRole
    ) : void {
        $this->recordMessage(Messages\MediRoleAppended::new($this->userId, $mediRole));
    }

}