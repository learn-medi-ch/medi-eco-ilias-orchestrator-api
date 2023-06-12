<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\DataSourceAdapters;

use Shuchkin\SimpleXLSX;

class MediCurriculumsExcelService
{
    private function __construct(
        private string $excelImportDirectoryPath,
        private string $prefixFilePath
    )
    {

    }

    public static function new(string $excelImportDirectoryPath, string $prefixFilePath)
    {
        return new self($excelImportDirectoryPath, $prefixFilePath);
    }

    public function readClasses(): MediClass
    {
        foreach (MediFacultyType::cases() as $facultyType) {
            $filePathName = $this->excelImportDirectoryPath . "/" . $this->prefixFilePath . "-" . $facultyType->value . ".xlsx";//todo find a accurate way
            if (file_exists($filePathName) === true) {
                $xlsx = SimpleXLSX::parse($filePathName);
            }
        }
    }

}