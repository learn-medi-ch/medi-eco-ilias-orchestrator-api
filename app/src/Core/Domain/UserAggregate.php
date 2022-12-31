<?php

namespace MediEco\IliasUserOrchestratorApi\Core\Domain;

class UserAggregate
{
    private array $recordedMessages = [];
    public ?ValueObjects\UserData $userData = null;
    public array $additionalFields = [];

    private function __construct(private ValueObjects\UserId $userId)
    {

    }

    /**
     * @return static
     */
    public static function new(
        ValueObjects\UserId $userId
    ): self
    {
        return new self($userId);
    }

    private function recordMessage(Messages\Message $message): void  {
        $this->recordedMessages[] = $message;
    }

    public function getAndResetRecordedMessages(): array {
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
    ):  void {
        $this->applyCreateOrUpdateUser(Messages\CreateOrUpdateUser::new($this->userId , $userData, $additionalFields));
    }

    private function applyCreateOrUpdateUser(Messages\CreateOrUpdateUser $createOrUpdateUser) {
        $this->userData = $createOrUpdateUser->userData;
        $this->additionalFields = $createOrUpdateUser->additionalFields;
        $this->recordMessage($createOrUpdateUser);
    }
}