<?php
namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum FacultyId: string
{
    case BMA = "bma";
    case RS = "rs";
    case OT = "ot";
    case OT_UP = "OT"; //todo

    case MTR = "mtr";
    case AT = "at";
    case AMB = "amb";
    case DH = "dh";
    case DIREKTION = "direktion";

    public function toExcelFilePath(string $excelImportDirectory): string
    {
        return $excelImportDirectory . "/Benutzerexport-SSO-" . strtoupper($this->value) . ".xlsx";
    }

    public function toUrlParameter(): string  {
        return "faculty-id/".$this->value;
    }

    public static function asCommaSeparatedString(): string {
        $cases = [];
        foreach(self::cases() as $case) {
            $cases[] = $case->value;
        }
        return implode(",",$cases);
    }
}