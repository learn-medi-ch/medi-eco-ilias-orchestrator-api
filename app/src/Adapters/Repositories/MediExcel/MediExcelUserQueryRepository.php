<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\MediExcel;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

use xlsx\src\SimpleXLSX;

class MediExcelUserQueryRepository implements Ports\User\UserQueryRepository
{
    private function __construct(
        public string $excelImportDirectoryPath
    ) {

    }

    public static function new(string $excelImportDirectoryPath)
    {
        return new self($excelImportDirectoryPath);
    }

    /**
     * @param string $facultyId
     * @return Ports\user\UserDto[]
     */
    public function getFacultyUsers(string $facultyId) : array
    {
        $users = [];
        $xlsx = SimpleXLSX::parse(ValueObjects\FacultyId::from($facultyId)->toExcelFilePath($this->excelImportDirectoryPath));
        foreach ($xlsx->rows() as $rowIndex => $row) {
            $additionalFields = [];
            if ($rowIndex === 0) {
                continue;
            }

            $userId = ValueObjects\UserId::fromAddressNr($row[MediExcelUserColumnId::ID->value]);

            $additionalFields = [
                ValueObjects\AdditionalField::new(ValueObjects\RoleId::FACULTY_EXPERT->toFieldName(),
                    $row[MediExcelUserColumnId::BG_FACHTEAM->value]),
                ValueObjects\AdditionalField::new(ValueObjects\RoleId::FACULTY_ADMIN->toFieldName(),
                    $row[MediExcelUserColumnId::BG_ADMIN->value]),
                ValueObjects\AdditionalField::new(ValueObjects\RoleId::FACULTY_LECTURER->toFieldName(),
                    $row[MediExcelUserColumnId::BG_DOZIERENDE->value]),
                ValueObjects\AdditionalField::new(ValueObjects\RoleId::FACULTY_VOCATIONAL_TRAINER->toFieldName(),
                    $row[MediExcelUserColumnId::BG_BERUFSBILDENDE->value]),
                ValueObjects\AdditionalField::new(ValueObjects\RoleId::FACULTY_STUDENT->toFieldName(),
                    $row[MediExcelUserColumnId::BG_STUDIERENDE->value]),
                ValueObjects\AdditionalField::new(ValueObjects\DegreeProgram::toFieldName(),
                    $row[MediExcelUserColumnId::SCHOOL_CLASS->value]),
            ];

            $users[] = Ports\User\UserDto::new(
                $userId,
                ValueObjects\UserData::new(
                    $row[MediExcelUserColumnId::E_MAIL->value],
                    $row[MediExcelUserColumnId::FIRST_NAME->value],
                    $row[MediExcelUserColumnId::LAST_NAME->value],
                    $row[MediExcelUserColumnId::E_MAIL->value],
                ),
                $additionalFields
            );
        }

        return $users;
    }
}