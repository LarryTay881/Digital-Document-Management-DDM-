<h1>Upload Form Report</h1>

<table border="1">
    <thead>
        <tr>
            <th>{{ __('messages.No') }}</th>
            <th>{{ __('messages.Upload_By') }}</th>
            <th>{{ __('messages.Date_Time') }}</th>
            <th>{{ __('messages.File_Name') }}</th>
            <th>{{ __('messages.Uuid') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->upload_by }}</td>
            <td>{{ $item->date_time }}</td>
            <td>{{ $item->file_name }}</td>
            <td>{{ $item->uuid }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
