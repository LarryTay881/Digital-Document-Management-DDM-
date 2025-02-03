<?php

namespace App\Exports;

use App\Models\FileUpload;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FileUploadExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return FileUpload::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Upload By',
            'Date Time',
            'File Name',
            'UUID',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->upload_by,
            $row->date_time,
            $row->file_name,
            $row->uuid,
        ];
    }
}
