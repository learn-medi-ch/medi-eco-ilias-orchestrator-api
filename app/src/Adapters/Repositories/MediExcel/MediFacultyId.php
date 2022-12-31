<?php
namespace MediEco\IliasUserOrchestratorApi\Adapters\Repositories\MediExcel;

enum MediFacultyId: string
{
    case BMA = "bma";
    case RS = "rs";
    case OT = "ot";
    case AT = "at";
    case AMB = "amb";
    case DH = "dh";

    public function toExcelFilePath(string $excelImportDirectory): string
    {
        return $excelImportDirectory . "/Benutzerexport-SSO-" . strtoupper($this->value) . ".xlsx";
    }

    public function toUrlParameter(): string  {
        return "faculty-id/".$this->value;
    }
}