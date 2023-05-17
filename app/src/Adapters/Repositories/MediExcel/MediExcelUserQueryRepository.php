<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\MediExcel;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\UserData;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;
use Shuchkin\SimpleXLSX;

class MediExcelUserQueryRepository implements Ports\User\UserQueryRepository
{
    private function __construct(
        public string $excelImportDirectoryPath
    )
    {

    }

    public static function new(string $excelImportDirectoryPath)
    {
        return new self($excelImportDirectoryPath);
    }

    /**
     * @param string $facultyId
     * @return UserData[]
     */
    public function getFacultyUsers(string $facultyId): array
    {
        $users = [];

        $xlsx = SimpleXLSX::parse(ValueObjects\FacultyId::from($facultyId)->toExcelFilePath($this->excelImportDirectoryPath));
        foreach ($xlsx->rows() as $rowIndex => $row) {
            $additionalFields = [];
            if ($rowIndex === 0) {
                continue;
            }

            $importId = ValueObjects\MediUserImportId::fromMediAddressNr($row[MediExcelUserColumnId::ID->value]);

            $email = $row[MediExcelUserColumnId::E_MAIL->value];
            $firstName = $row[MediExcelUserColumnId::FIRST_NAME->value];
            $lastName = $row[MediExcelUserColumnId::LAST_NAME->value];

            $studentFaculties = $row[MediExcelUserColumnId::BG_STUDIERENDE->value];
            $studentSchoolClass = $row[MediExcelUserColumnId::SCHOOL_CLASS->value];

            $lecturerFaculties = $row[MediExcelUserColumnId::BG_DOZIERENDE->value];
            $expertFaculties = $row[MediExcelUserColumnId::BG_FACHTEAM->value];
            $adminFaculties = $row[MediExcelUserColumnId::BG_ADMIN->value];

            $vocationalTrainerFaculties = $row[MediExcelUserColumnId::BG_BERUFSBILDENDE->value];

            $roleImportIds = $this->getRoleImportIds($studentFaculties, $lecturerFaculties, $expertFaculties, $adminFaculties, $vocationalTrainerFaculties);

            $users[] = match (true) {
                str_contains($email, 'medibern.ch') => ValueObjects\MediStudentData::new($importId, $email, $firstName, $lastName, $roleImportIds, $studentFaculties, $studentSchoolClass),
                str_contains($email, 'medi.ch') => ValueObjects\MediStaffData::new($importId, $email, $firstName, $lastName, $roleImportIds, $lecturerFaculties, $expertFaculties),
                default => ValueObjects\MediExternalUserData::new($importId, $email, $firstName, $lastName, $roleImportIds, $vocationalTrainerFaculties),
            };

        }

        print_r($users);

        return $users;
    }

    private function getRoleImportIds(
        string $studentFaculties,
        string $lecturerFaculties,
        string $expertFaculties,
        string $adminFaculties,
        string $vocationalTrainerFaculties
    ): array
    {
        $roleImportIds = [];
        $roleImportIds = $this->appendRoleIdsStudent($roleImportIds, $studentFaculties);
        $roleImportIds = $this->appendRoleIdsLecturer($roleImportIds, $lecturerFaculties);
        $roleImportIds = $this->appendRoleIdAdmin($roleImportIds, $adminFaculties);
        $roleImportIds = $this->appendRoleIdMediStaff($roleImportIds, $lecturerFaculties, $expertFaculties);
        $roleImportIds = $this->appendRoleIdSandbox($roleImportIds, $lecturerFaculties, $expertFaculties);
        $roleImportIds = $this->appendRoleIdVocationalTrainiers($roleImportIds, $vocationalTrainerFaculties);
        return $roleImportIds;
    }

    private function appendRoleIdsStudent(
        array  $roleImportIds,
        string $studentFaculties
    ): array
    {
        if (strlen($studentFaculties) > 0) {
            foreach (explode(", ", $studentFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediGeneralRoleId::FACULTY_STUDENTS->toRoleImportIdString($facultyId);
            }
        }
        return $roleImportIds;
    }

    private function appendRoleIdsLecturer(
        array  $roleImportIds,
        string $lecturerFaculties
    ): array
    {
        if (strlen($lecturerFaculties) > 0) {
            foreach (explode(", ", $lecturerFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediGeneralRoleId::FACULTY_LECTURERS->toRoleImportIdString($facultyId);
            }
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::LECTURERS->toRoleImportIdString($facultyId);
        }
        return $roleImportIds;
    }

    private function appendRoleIdAdmin(
        array  $roleImportIds,
        string $adminFaculties
    ): array
    {
        if (strlen($adminFaculties) > 0) {
            foreach (explode(", ", $adminFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediGeneralRoleId::FACULTY_ADMINS->toRoleImportIdString($facultyId);
            }
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::ADMINS->toRoleImportIdString();
        }
        return $roleImportIds;
    }

    private function appendRoleIdSandbox(
        array  $roleImportIds,
        string $lecturerFaculties,
        string $expertFaculties,
    ): array
    {
        if (strlen($lecturerFaculties) > 0 || strlen($expertFaculties) > 0) {
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::MEDI_SANDBOX->toRoleImportIdString();
        }
        return $roleImportIds;
    }

    private function appendRoleIdMediStaff(
        array  $roleImportIds,
        string $lecturerFaculties,
        string $expertFaculties,
    ): array
    {
        if (strlen($lecturerFaculties) > 0 || strlen($expertFaculties) > 0) {
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::MEDI_STAFF->toRoleImportIdString();
        }
        return $roleImportIds;
    }

    private function appendRoleIdVocationalTrainiers(
        array  $roleImportIds,
        string $vocationalTrainerFaculties,
    ): array
    {
        if (strlen($vocationalTrainerFaculties) > 0) {
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::FACULTY_VOCATIONAL_TRAINERS->toRoleImportIdString($vocationalTrainerFaculties);
        }
        return $roleImportIds;
    }

}