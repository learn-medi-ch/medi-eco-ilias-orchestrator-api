<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\CourseMember\CourseMemberDiffDto;
use FluxIliasRestApiClient\Libs\FluxIliasBaseApi\Adapter\Object\DefaultObjectType;
use  MediEco\IliasUserOrchestratorOrbital\Core\Domain;

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
        $factultyId = $message->facultyId->value;
        $schoolYear = $message->schoolYear;

        $schoolClass = strtoupper($factultyId) . " " . $schoolYear;
        $schoolClassCrs = "crs_" . $factultyId . "_" . $schoolYear;
        $schoolClassTree = "cat_" . $factultyId . "_" . $schoolYear;

        $filteredUsers = $this->getStudentsByFacultyAndSchoolYear($schoolClass);
        $this->subscribeToSchoolClassCourse($filteredUsers, $schoolClassCrs);
        $this->subscribeToSchoolClassCourseTree($filteredUsers, $schoolClassTree);

        $publish("Ok: " . $message->getName()->toUrlParameter());
    }

    private function getStudentsByFacultyAndSchoolYear(
        string $schoolClass
    )
    {
        $iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $users = $iliasRestApiClient->getUsers(null, null, null, null, false, false, false, true);
        $filteredUserIds = [];
        foreach ($users as $user) {
            if (count($user->user_defined_fields) > 0) {
                if ($user->user_defined_fields[0]->value === $schoolClass) {
                    $filteredUserIds[] = $user->id;
                }
            }
        }
        return $filteredUserIds;
    }

    private function subscribeToSchoolClassCourse(array $filteredUserIds, string $schoolClassCrs)
    {
        $iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $crs = $iliasRestApiClient->getCourseByImportId($schoolClassCrs);
        if ($crs) {
            $this->subscribeToCourse($crs->ref_id, $filteredUserIds);
        }
    }

    private function subscribeToSchoolClassCourseTree(array $filteredUserIds, string $schoolClassTreeName)
    {
        $iliasRestApiClient = $this->outbounds->iliasRestApiClient;
        $category = $iliasRestApiClient->getCategoryByImportId($schoolClassTreeName);
        $this->subscribeToTree((int)$category->ref_id, $filteredUserIds);
    }

    private function subscribeToTree(int $refId, array $userIds)
    {
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
    }

    private function subscribeToCourse(int $ref_id, array $userIds)
    {
        foreach ($userIds as $userId) {
            $this->outbounds->iliasRestApiClient->addCourseMemberByRefIdByUserId($ref_id, $userId, CourseMemberDiffDto::new(true));
        }
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
        callable                     $publish
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