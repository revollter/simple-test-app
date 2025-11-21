<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\DataRepository;

class DataExportService
{
    public function __construct(
        private DataRepository $dataRepository
    )
    {
    }

    public function generateSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User name');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Product');
        $sheet->setCellValue('E1', 'Color');
        $sheet->setCellValue('F1', 'Amount');

        $dataList = $this->dataRepository->findAll();

        $row = 2;
        foreach ($dataList as $item) {
            $sheet->setCellValue('A'.$row, $item->getId());
            $sheet->setCellValue('B'.$row, $item->getUser()->getFullName() ?? '');
            $sheet->setCellValue('C'.$row, $item->getDate()?->format('Y-m-d'));
            $sheet->setCellValue('D'.$row, $item->getProduct()?->value ?? '');
            $sheet->setCellValue('E'.$row, $item->getColor()?->value ?? '');
            $sheet->setCellValue('F'.$row, $item->getAmount());
            $row++;
        }

        return $spreadsheet;
    }

    public function createWriter(Spreadsheet $spreadsheet): Xlsx
    {
        return new Xlsx($spreadsheet);
    }
}
