<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserProfileReportExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            ['PALAWAN STATE UNIVERSITY'], // Title row
            ['LIST OF GRADUATES'], // Subtitle row
            [''], // Empty row
            ['Last Name', 'First Name', 'Middle Name', 'Address', 'Campus', 'Program'], // Table headers
        ];
    }

    public function title(): string
    {
        return 'Graduate List'; // Sheet title
    }

    public function styles(Worksheet $sheet)
    {
        // Merge and center the title row (Row 1)
        $sheet->mergeCells('A1:F1'); // Adjust range based on your columns
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Merge and center the subtitle row (Row 2)
        $sheet->mergeCells('A2:F2'); // Adjust range based on your columns
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

        return [
            // Style the title row
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => 'center']],
            // Style the subtitle row
            2 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            // Style table headers
            4 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],
        ];
    }
}
