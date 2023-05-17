<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum FacultyId: string
{
    case AMB = "amb";
    case AT = "at";
    case BMA = "bma";
    case DH = "dh";
    case MTR = "mtr";
    case OT = "ot";
    case RS = "rs";


    public function toExcelFilePath(string $excelImportDirectory): string
    {
        return $excelImportDirectory . "/Benutzerexport-SSO-" . strtoupper($this->value) . ".xlsx";
    }

    public function toUrlParameter(): string
    {
        return "faculty-id/" . $this->value;
    }

    public static function asCommaSeparatedString(): string
    {
        $cases = [];
        foreach (self::cases() as $case) {
            $cases[] = $case->value;
        }
        return implode(",", $cases);
    }
}