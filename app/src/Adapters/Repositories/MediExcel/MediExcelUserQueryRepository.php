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

            $importId = ValueObjects\MediUserImportId::fromMediAddressNr($row[MediExcelUserColumnId::ID->value])->id;

            $email = $row[MediExcelUserColumnId::E_MAIL->value];
            $firstName = $row[MediExcelUserColumnId::FIRST_NAME->value];
            $lastName = $row[MediExcelUserColumnId::LAST_NAME->value];

            $studentFaculties = $row[MediExcelUserColumnId::BG_STUDIERENDE->value];
            $studentSchoolClass = $row[MediExcelUserColumnId::SCHOOL_CLASS->value];

            $lecturerFaculties = $row[MediExcelUserColumnId::BG_DOZIERENDE->value];
            $expertFaculties = $row[MediExcelUserColumnId::BG_FACHTEAM->value];
            $adminFaculties = $row[MediExcelUserColumnId::BG_ADMIN->value];

            $vocationalTrainerFaculties = $row[MediExcelUserColumnId::BG_BERUFSBILDENDE->value];
            $roleImportIds = $this->appendRoleImportIdsToArray([], $studentFaculties, $lecturerFaculties, $expertFaculties, $adminFaculties, $vocationalTrainerFaculties);

            $users[] = match (true) {
                str_contains($email, 'medibern.ch') => ValueObjects\MediStudentData::new($importId, $email, $firstName, $lastName, $roleImportIds, $studentFaculties, $studentSchoolClass),
                str_contains($email, 'medi.ch') => ValueObjects\MediStaffData::new($importId, $email, $firstName, $lastName, $roleImportIds, $lecturerFaculties, $expertFaculties),
                default => ValueObjects\MediExternalUserData::new($importId, $email, $firstName, $lastName, $roleImportIds, $vocationalTrainerFaculties),
            };

        }

        print_r($users);

        return $users;
    }

    private function appendRoleImportIdsToArray(
        array  $roleImportIds,
        string $studentFaculties,
        string $lecturerFaculties,
        string $expertFaculties,
        string $adminFaculties,
        string $vocationalTrainerFaculties
    ): array
    {
        $roleImportIds = $this->appendRoleImportIdsStudentToArray($roleImportIds, $studentFaculties);
        $roleImportIds = $this->appendRoleImportIdsLecturerToArray($roleImportIds, $lecturerFaculties);
        $roleImportIds = $this->appendRoleImportIdAdminToArray($roleImportIds, $adminFaculties);
        $roleImportIds = $this->appendRoleImportIdMediStaffToArray($roleImportIds, $lecturerFaculties, $expertFaculties);
        $roleImportIds = $this->appendRoleImportIdSandboxToArray($roleImportIds, $lecturerFaculties, $expertFaculties);
        $roleImportIds = $this->appendRoleImportIdVocationalTrainiersToArray($roleImportIds, $vocationalTrainerFaculties);
        return $roleImportIds;
    }

    private function appendCourseRoleImportIdsToArray() {

    }

    private function appendRoleImportIdsStudentToArray(
        array  $roleImportIds,
        string $studentFaculties
    ): array
    {
        if (strlen($studentFaculties) > 0) {
            foreach (explode(", ", $studentFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediFacultyRoleId::FACULTY_STUDENTS->toImportId($facultyId);
            }
        }
        return $roleImportIds;
    }

    private function appendRoleImportIdsLecturerToArray(
        array  $roleImportIds,
        string $lecturerFaculties
    ): array
    {
        if (strlen($lecturerFaculties) > 0) {
            foreach (explode(", ", $lecturerFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediFacultyRoleId::FACULTY_LECTURERS->toImportId($facultyId);
            }
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::LECTURERS->toImportId($facultyId);
        }
        return $roleImportIds;
    }

    private function appendRoleImportIdAdminToArray(
        array  $roleImportIds,
        string $adminFaculties
    ): array
    {
        if (strlen($adminFaculties) > 0) {
            foreach (explode(", ", $adminFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediFacultyRoleId::FACULTY_ADMINS->toImportId($facultyId);
            }
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::ADMINS->toImportId();
        }
        return $roleImportIds;
    }

    private function appendRoleImportIdSandboxToArray(
        array  $roleImportIds,
        string $lecturerFaculties,
        string $expertFaculties,
    ): array
    {
        if (strlen($lecturerFaculties) > 0 || strlen($expertFaculties) > 0) {
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::MEDI_SANDBOX->toImportId();
        }
        return $roleImportIds;
    }

    private function appendRoleImportIdMediStaffToArray(
        array  $roleImportIds,
        string $lecturerFaculties,
        string $expertFaculties,
    ): array
    {
        if (strlen($lecturerFaculties) > 0 || strlen($expertFaculties) > 0) {
            $roleImportIds[] = ValueObjects\MediGeneralRoleId::MEDI_STAFF->toImportId();
        }
        return $roleImportIds;
    }

    private function appendRoleImportIdVocationalTrainiersToArray(
        array  $roleImportIds,
        string $vocationalTrainerFaculties,
    ): array
    {
        if (strlen($vocationalTrainerFaculties) > 0) {
            foreach (explode(", ", $vocationalTrainerFaculties) as $facultyId) {
                $roleImportIds[] = ValueObjects\MediFacultyRoleId::FACULTY_VOCATIONAL_TRAINERS->toImportId($facultyId);
            }
        }
        return $roleImportIds;
    }

}