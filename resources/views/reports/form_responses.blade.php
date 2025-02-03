<!DOCTYPE html>
<html>
<head>
    <h1>{{ $templateName }}</h1>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            @foreach($headings as $heading)
                <th>{{ ucwords(str_replace('_', ' ', $heading)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                @foreach($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
