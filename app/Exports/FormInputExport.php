<?php

namespace App\Exports;

use App\Models\FormInput;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormInputExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return FormInput::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Gender',
            'Date of Birth',
            'Address',
            'State',
            'City',
            'Country',
            'Postal Code',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->full_name,
            $row->gender,
            // Format date here
            Carbon::parse($row->date_of_birth)->format('Y-m-d'),
            $row->address,
            $row->state,
            $row->city,
            $row->country,
            $row->postal_code,
        ];
    }
}
