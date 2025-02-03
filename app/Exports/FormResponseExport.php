<?php

// App\Exports\FormResponseExport.php

namespace App\Exports;

use App\Models\FormResponse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormResponseExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        // Fetch form response data
        $formResponses = FormResponse::where('template_id', $this->id)->get();

        // Transform data as needed, assuming form_response is a JSON column
        $data = $formResponses->map(function ($formResponse) {
            $responseData = json_decode($formResponse->form_response, true);

            // Add the "uploaded by" information to each row at the beginning
            $responseData = ['uploaded_by' => $formResponse->upload_by] + $responseData;

            return $responseData;
        });

        return $data;
    }

    public function headings(): array
    {
        // Get the first form response to extract keys
        $formResponse = FormResponse::where('template_id', $this->id)->first();

        if ($formResponse) {
            // Decode JSON and extract keys
            $keys = array_keys(json_decode($formResponse->form_response, true));

            // Add a suffix to duplicate keys to make them unique
            $uniqueKeys = array_map(function ($key, $count) {
                return $count > 1 ? "{$key}_{$count}" : $key;
            }, array_count_values($keys), $keys);

            // Remove the prefix from the keys
            $cleanedKeys = array_map(function ($key) {
                return preg_replace('/^\d+_/', '', $key);
            }, $uniqueKeys);

            // Add the "uploaded by" key to the beginning of the headings
            array_unshift($cleanedKeys, 'Uploaded by');

            return $cleanedKeys;
        }

        return [];
    }
}
