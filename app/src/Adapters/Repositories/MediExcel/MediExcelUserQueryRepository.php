<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\MediExcel;
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
     * @return Ports\user\UserDto[]
     */
    public function getFacultyUsers(string $facultyId): array
    {
        $users = [];
        echo ValueObjects\MediFacultyId::from($facultyId)->toExcelFilePath($this->excelImportDirectoryPath);
        $xlsx = SimpleXLSX::parse(ValueObjects\MediFacultyId::from($facultyId)->toExcelFilePath($this->excelImportDirectoryPath));
        foreach ($xlsx->rows() as $rowIndex => $row) {
            $additionalFields = [];
            if ($rowIndex === 0) {
                continue;
            }

            $userId = ValueObjects\UserId::fromAddressNr($row[MediExcelUserColumnId::ID->value]);

            $additionalFields = [
                ValueObjects\AdditionalField::new(ValueObjects\MediAdditionalFieldName::BG_FACHTEAM->value, $row[MediExcelUserColumnId::BG_FACHTEAM->value]),
                ValueObjects\AdditionalField::new(ValueObjects\MediAdditionalFieldName::BG_ADMIN->value, $row[MediExcelUserColumnId::BG_ADMIN->value]),
                ValueObjects\AdditionalField::new(ValueObjects\MediAdditionalFieldName::BG_DOZIERENDE->value, $row[MediExcelUserColumnId::BG_DOZIERENDE->value]),
                ValueObjects\AdditionalField::new(ValueObjects\MediAdditionalFieldName::BG_BERUFSBILDE->value, $row[MediExcelUserColumnId::BG_BERUFSBILDENDE->value]),
                ValueObjects\AdditionalField::new(ValueObjects\MediAdditionalFieldName::BG_STUDIERENDE->value, $row[MediExcelUserColumnId::BG_STUDIERENDE->value])
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