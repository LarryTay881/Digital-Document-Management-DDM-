<h1>Employee Form Report</h1>

<table border="1">
    <thead>
        <tr>
            <th>{{ __('messages.No') }}</th>
            <th>{{ __('messages.Full_Name') }}</th>
            <th>{{ __('messages.Gender') }}</th>
            <th>{{ __('messages.Date_of_Birth') }}</th>
            <th>{{ __('messages.Address') }}</th>
            <th>{{ __('messages.State') }}</th>
            <th>{{ __('messages.City') }}</th>
            <th>{{ __('messages.Country') }}</th>
            <th>{{ __('messages.Postal_Code') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->full_name }}</td>
            <td>{{ $item->gender }}</td>
            <td>{{ $item->date_of_birth }}</td>
            <td>{{ $item->address }}</td>
            <td>{{ $item->state }}</td>
            <td>{{ $item->city }}</td>
            <td>{{ $item->country }}</td>
            <td>{{ $item->postal_code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
