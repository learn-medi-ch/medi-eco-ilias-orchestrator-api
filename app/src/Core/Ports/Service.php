<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\{Tree, Label, Tree\SpaceNode};
use  MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

//todo split up in userService, CategoryService, RoleService....
final readonly class Service
{

    private function __construct(
        private Label\Dictionary  $dictionary,
        private Tree\Repositories $repositories
    )
    {

    }

    public static function new(Outbounds $outbounds): Service
    {
        return new self($outbounds->dictionary, $outbounds->repositories);
    }

    /**
     * @param string $uniqueNameParent
     * @param TreePorts\Space $rootSpace
     * @return void
     */
    public function createTreeNodes(
        string          $uniqueNameParent,
        TreePorts\Space $rootSpace
    ): void
    {
        $rootNode = Tree\TreeAggregate::new($this->dictionary)->create($uniqueNameParent, $rootSpace);

        $this->repositories->spaceRepository->create($uniqueNameParent, $rootNode->uniqueName, $rootNode->label);
        $this->createSpaces($rootNode->uniqueName, $rootNode->spaces);
    }


    /**
     * @param string $parentUniqueName
     * @param Tree\SpaceNode[]|null $spaces
     * @return void
     */
    public function createSpaces(string $parentUniqueName, ?array $spaces): void
    {
        if ($spaces === null) {
            return;
        }

        array_map(fn($space) => $this->repositories->spaceRepository->create($parentUniqueName, $space->uniqueName, $space->label), $spaces);
        array_map(fn($space) => $this->createSpaces($space->uniqueName, $space->spaces), $spaces);
        array_map(fn($space) => $this->createRooms($space->uniqueName, $space->rooms), $spaces);
        array_map(fn($space) => $this->createRoles($space->uniqueName, $space->roles), $spaces);
    }

    /**
     * @param string $parentSpaceUniqueName
     * @param Tree\RoomNode[]|null $rooms
     * @return void
     */
    public function createRooms(string $parentSpaceUniqueName, ?array $rooms): void
    {
        if ($rooms === null) {
            return;
        }
        array_map(fn($room) => $this->repositories->roomRepository->create($parentSpaceUniqueName, $room->uniqueName, $room->label), $rooms);
    }

    /**
     * @param string $parentSpaceUniqueName
     * @param Tree\RoleNode[]|null $roles
     * @return void
     */
    public function createRoles(string $parentSpaceUniqueName, ?array $roles): void
    {
        if ($roles === null) {
            return;
        }
        array_map(fn($role) => $this->repositories->roleRepository->create($parentSpaceUniqueName, $role->uniqueName, $role->label), $roles);
    }

/*

    private function createMediFacultyCoursesForPersonGroups(string $facultyId): void
    {
        //course for faculty group (gremium) vocational trainers
        $this->createCourse(
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_VOCATIONAL_TRAINERS->toCourseImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_VOCATIONAL_TRAINERS->toCourseTitle($facultyId),
        );

        //course for faculty group (gremium) lecturers
        $this->createCourse(
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_LECTURERS->toCourseImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_LECTURERS->toCourseTitle($facultyId),
        );

        //course for faculty group (gremium) experts
        $this->createCourse(
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_EXPERTS->toCourseImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_EXPERTS->toCourseTitle($facultyId),
        );


        //course for faculty group (gremium) students
        $this->createCourse(
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_STUDENTS->toCourseImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_STUDENTS->toCourseTitle($facultyId),
        );
    }

    private function createFacultySchoolClassCourse(string $facultyId, string $schoolClassName)
    {
        //school class under the purview of a faculty
        $this->createCourse(
            ValueObjects\MediFacultyCategoryId::FACULTY_SCHOOL_CLASSES->toImportId($facultyId),


            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_VOCATIONAL_TRAINERS->toCourseImportId($facultyId),
            ValueObjects\MediFacultyCourseId::FACULTY_GROUP_VOCATIONAL_TRAINERS->toCourseTitle($facultyId),
        );
    }

    private function createCourse(string $parentImportId, string $importId, string $title)
    {
        $repository = $this->outbounds->courseRepository;
        $course = $repository->getCourseByImportId($importId);
        match ($course) {
            null => $repository->createCourse($parentImportId, $importId, $title),
            default => []
        };
    }

    private function createMediFacultyCategories(string $facultyId): void
    {
        //root node of faculty tree
        $this->createSpaces(
            ValueObjects\MediGeneralCategoryId::FACULTIES->toImportId(),
            ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toTitle($facultyId)
        );

        $facultyRootImportId = ValueObjects\MediFacultyCategoryId::FACULTY_ROOT->toImportId($facultyId);
        //node for curriculums
        $this->createSpaces(
            $facultyRootImportId,
            ValueObjects\MediFacultyCategoryId::FACULTY_CURRICULUM->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_CURRICULUM->toTitle($facultyId),
        );
        //node for groups
        $this->createSpaces(
            $facultyRootImportId,
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toImportId($facultyId),
            ValueObjects\MediFacultyCategoryId::FACULTY_GROUPES->toTitle($facultyId),
        );
        //node for school classes
        $this->createSpaces(
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
*/


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