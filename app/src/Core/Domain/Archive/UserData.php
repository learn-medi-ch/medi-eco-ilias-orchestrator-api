<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;


/**
 * @property string $importId //todo think about providing only the typed Id
 * @property int $userId
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $login
 * @property array $roleImportIds
 * @property string $externalId
 * @property string $authMode
 * @property AdditionalField[] $additionalFields
 */
interface UserData
{

}