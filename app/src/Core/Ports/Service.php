<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use  MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

//todo split up in userService, CategoryService, RoleService....
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

    public function createMediGeneralCategories(): void
    {
        $repository = $this->outbounds->categoryRepository;
        foreach (ValueObjects\MediGeneralCategoryId::cases() as $categoryId) {
            $category = $repository->getCategoryByImportId($categoryId->toImportId());
            match ($category) {
                null => $repository->createCategoryToRootNode($categoryId->toImportId(), $categoryId->toTitle()),
                default => []
            };
        }
    }

    public function createMediFacultiesCategories(): void
    {
        foreach (ValueObjects\FacultyId::cases() as $facultyId) {
            $this->createMediFacultyCategories($facultyId->value);
        }
    }

    private function createMediFacultyCategories(string $facultyId): void
    {
        $this->createCategory(
            ValueObjects\MediGeneralCategoryId::FACULTIES->toImportId(),
            ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toTitle($facultyId)
        );

        $facultyRootImportId = ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toImportId($facultyId);
        $this->createCategory(
            $facultyRootImportId,
            ValueObjects\MediFacultyCategoryId::FACULTY_CURRICULUM->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_CURRICULUM->toTitle($facultyId),
        );
        $this->createCategory(
            $facultyRootImportId,
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toTitle($facultyId),
        );
        $this->createCategory(
            $facultyRootImportId,
            ValueObjects\MediFacultyCategoryId::FACULTY_SCHOOL_CLASSES->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_SCHOOL_CLASSES->toTitle($facultyId),
        );
    }

    private function createCategory(string $parentImportId, string $importId, string $title)
    {
        $repository = $this->outbounds->categoryRepository;
        $category = $repository->getCategoryByImportId($importId);
        match ($category) {
            null => $repository->createCategory($parentImportId, $importId, $title),
            default => []
        };
    }

    public function createMediGeneralRoles(): void
    {
        $roleRepository = $this->outbounds->roleRepository;

        foreach (ValueObjects\MediGeneralRoleId::cases() as $roleIdSuffix) {
            $role = $roleRepository->getRoleByRoleByImportId($roleIdSuffix->toImportId());
            match ($role) {
                null => $roleRepository->createGlobalRole($roleIdSuffix->toImportId(), $roleIdSuffix->toRoleTitle()),
                default => []
            };
        }
    }

    public function createMediFacultiesRoles(): void
    {
        foreach (ValueObjects\FacultyId::cases() as $facultyId) {
            $this->createMediFacultyRoles($facultyId->value);
        }
    }

    private function createMediFacultyRoles(string $facultyId): void
    {
        $roleRepository = $this->outbounds->roleRepository;
        foreach (ValueObjects\MediFacultyRoleId::cases() as $roleId) {
            $role = $roleRepository->getRoleByRoleByImportId($roleId->toImportId($facultyId));
            match ($role) {
                null => $roleRepository->createLocalRole(ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toImportId($facultyId), $roleId->toImportId($facultyId), $roleId->toTitle($facultyId)),
                default => []
            };
        }
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
            echo "*********" . PHP_EOL;
            echo $user->importId . PHP_EOL;
            echo "*********" . PHP_EOL;

            $this->createOrUpdateUser($user);
            $this->subscribeToRoles($user->importId, $user->roleImportIds);


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

    private function createOrUpdateUser(ValueObjects\UserData $user)
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository; //todo
        $iliasUser = $iliasUserRepository->getUserByImportId(
            $user->importId
        );
        match ($iliasUser) {
            null => $this->createUser($user),
            default => $this->updateUser($user),
        };
    }

    private function createUser(ValueObjects\UserData $userData): void
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository;
        $iliasUserRepository->create($userData);
    }

    private function updateUser(ValueObjects\UserData $userData): void
    {
        $iliasUserRepository = $this->outbounds->iliasUserRepository;
        $iliasUserRepository->update($userData);
    }

    private function subscribeToRoles(string $userImportId, array $roleImportIds): void
    {
        print_r($roleImportIds);

        $iliasUserRepository = $this->outbounds->iliasUserRepository;
        $subscribedRoleImportIds = $iliasUserRepository->getSubscribedRoleImportIds($userImportId);
        foreach ($roleImportIds as $roleImportIdToSubscribeTo) {

            echo "*********" . PHP_EOL;
            echo "subscribe user to Role...." . PHP_EOL;
            echo $userImportId . PHP_EOL;
            echo $roleImportIdToSubscribeTo . PHP_EOL;
            echo "*********" . PHP_EOL;

            if (in_array($roleImportIdToSubscribeTo, $subscribedRoleImportIds) === false) {
                $iliasUserRepository->subscribeToRole($userImportId, $roleImportIdToSubscribeTo);
            }
        }
    }

    /*public function handleSubscriptions(
        Messages\HandleSubscriptions $message
    )
    {
        $aggregate = Domain\UserAggregate::new($message->userId);
        if ($message->newAdditionalFieldValue === "" || $message->newAdditionalFieldValue === null) {
            $oldFacultyIds = array_map('trim', explode(',', $message->oldAdditionalFieldValue));
            foreach ($oldFacultyIds as $facultyId) {
                $aggregate->removeRole(Domain\ValueObjects\MediRole::new(Domain\ValueObjects\FacultyId::from($facultyId),
                    $message->roleId));
            }
        } else {
            $oldFacultyIds = array_map('trim', explode(',', $message->oldAdditionalFieldValue));
            $newFacultyIds = array_map('trim', explode(',', $message->newAdditionalFieldValue));
            foreach ($newFacultyIds as $facultyId) {
                $aggregate->appendRole(Domain\ValueObjects\MediRole::new(Domain\ValueObjects\FacultyId::from($facultyId),
                    $message->roleId));
            }
            foreach ($oldFacultyIds as $facultyId) {
                if ($facultyId === "") {
                    continue;
                }
                if (in_array($facultyId, $newFacultyIds) === false) {
                    $aggregate->removeRole(Domain\ValueObjects\MediRole::new(Domain\ValueObjects\FacultyId::from($facultyId),
                        $message->roleId));
                }
            }
        }
        $this->dispatchMessages($aggregate->getAndResetRecordedMessages());
    }*/

    /*private function dispatchMessages(array $recordedMessages)
    {
        if (count($recordedMessages) > 0) {
            foreach ($recordedMessages as $message) {
                $this->outbounds->userMessageDispatcher->dispatch($message);
            }
        }
    }*/
}