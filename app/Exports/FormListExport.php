<?php

namespace App\Exports;

use App\Models\FormTemplate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormListExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return FormTemplate::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Upload By',
            'Date Time',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->upload_by,
            $row->date_time,
        ];
    }
}
