<h1>Form List</h1>

<table border="1">
    <thead>
        <tr>
            <th>{{ __('messages.Id') }}</th>
            <th>{{ __('messages.Upload_By') }}</th>
            <th>{{ __('messages.Date_Time') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->upload_by }}</td>
            <td>{{ $item->date_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
