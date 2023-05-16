<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\CourseMember\CourseMemberDiffDto;
use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\Object\DefaultObjectType;
use  MediEco\IliasUserOrchestratorOrbital\Core\Domain;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\MediStudentData;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports\User\UserDto;

class Service
{

    private function __construct(
        private Outbounds $outbounds
    )
    {

    }

    public static function new(Outbounds $outbounds)
    {
        return new self($outbounds);
    }

    public function subscribeStudents(Messages\SubscribeStudents $message, callable $publish): void
    {
        /*
        $factultyId = $message->facultyId->value;
        $schoolYear = $message->schoolYear;

        $schoolClass = strtoupper($factultyId) . " " . $schoolYear;
        $schoolClassCrs = "crs_" . $factultyId . "_" . $schoolYear;
        $schoolClassTree = "cat_" . $factultyId . "_" . $schoolYear;

        $filteredUsers = $this->getStudentsByFacultyAndSchoolYear($schoolClass);
        $this->subscribeToSchoolClassCourse($filteredUsers, $schoolClassCrs);
        $this->subscribeToSchoolClassCourseTree($filteredUsers, $schoolClassTree);

        $publish("Ok: " . $message->getName()->toUrlParameter());
        */
    }

    private function getStudentsByFacultyAndSchoolYear(
        string $schoolClass
    )
    {
        /*$iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $users = $iliasRestApiClient->getUsers(null, null, null, null, false, false, false, true);
        $filteredUserIds = [];
        foreach ($users as $user) {
            if (count($user->user_defined_fields) > 0) {
                if ($user->user_defined_fields[0]->value === $schoolClass) {
                    $filteredUserIds[] = $user->id;
                }
            }
        }
        return $filteredUserIds;*/
    }

    private function subscribeToSchoolClassCourse(array $filteredUserIds, string $schoolClassCrs)
    {
        /*$iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $crs = $iliasRestApiClient->getCourseByImportId($schoolClassCrs);
        if ($crs) {
            $this->subscribeToCourse($crs->ref_id, $filteredUserIds);
        }*/
    }

    private function subscribeToSchoolClassCourseTree(array $filteredUserIds, string $schoolClassTreeName)
    {
        /*$iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $category = $iliasRestApiClient->getCategoryByImportId($schoolClassTreeName);
        $this->subscribeToTree((int)$category->ref_id, $filteredUserIds);*/
    }

    private function subscribeToTree(int $refId, array $userIds)
    {
        /*
        $categories = $this->outbounds->iliasRestApiClient->getChildrenByRefId($refId, DefaultObjectType::CATEGORY);
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $this->subscribeToTree($category->ref_id, $userIds);
            }
        }
        $courses = $this->outbounds->iliasRestApiClient->getChildrenByRefId($refId, DefaultObjectType::COURSE);
        if (count($courses) > 0) {
            foreach ($courses as $course) {
                $this->subscribeToCourse($course->ref_id, $userIds);
                echo $course->ref_id;
                echo $course->ref_id;
            }
        }
        */
    }

    private function subscribeToCourse(int $ref_id, array $userIds)
    {
        /*
        foreach ($userIds as $userId) {
            $this->outbounds->iliasRestApiClient->addCourseMemberByRefIdByUserId($ref_id, $userId, CourseMemberDiffDto::new(true));
        }
        */
    }


    public function importUsers(Messages\ImportUsers $message, callable $publish)
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository; //todo

        $usersToHandle = $this->outbounds->userQueryRepository->getFacultyUsers($message->facultyId->value);

        $recordedMessages = [];
        foreach ($usersToHandle as $user) {
            echo "*********".PHP_EOL;
            echo $user->importId->id.PHP_EOL;
            echo "*********".PHP_EOL;
            $iliasUser = $iliasUserRepository->getUserByImportId(
                $user->importId->id
            );

            match ($iliasUser) {
                null => $this->createUser($user),
                default => $this->updateUser($user),
            };


            // $this->outbounds->iliasRestApiClient->get


            /**
             * $iliasUser = $this->outbounds->userRepository->get($message->userId);
             * $aggregate = UserAggregate::new(
             * $message->userId,
             * );
             * if ($iliasUser === null) {
             * $this->createUser($aggregate, $message->userData, $message->additionalFields);
             * } else {
             * $aggregate->reconstitue($iliasUser->userData, $iliasUser->additionalFields);
             * $this->updateUser($aggregate, $message->userData, $message->additionalFields);
             * }
             */

            // $aggregate = Domain\UserAggregate::new($user->userId);
            // $aggregate->createOrUpdateUser($user->userData, array_values($user->additionalFields));
            // $recordedMessages = array_merge($recordedMessages, $aggregate->getAndResetRecordedMessages());
        }
        //$this->dispatchMessages($recordedMessages);

        /*
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
                        )
                    );
                }
            }
        }*/

        $publish("Ok: " . $message->getName()->toUrlParameter());
    }

    private function createUser(Domain\ValueObjects\UserData $userData): void
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository;
        $iliasUserRepository->create($userData);
    }

    private function updateUser(Domain\ValueObjects\UserData $userData): void
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository;
        $iliasUserRepository->update($userData);
    }

    private function subscribeToRoles(string $importId, MediStudentData $userData) {

    }

    public function handleSubscriptions(
        Messages\HandleSubscriptions $message
    )
    {
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