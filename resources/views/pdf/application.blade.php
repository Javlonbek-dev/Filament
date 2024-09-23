<!DOCTYPE html>
<html>
<head>
    <title>Application Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Application Details</h2>

<table>
    <tr>
        <th>Name</th>
        <td>{{ $name }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $phone }}</td>
    </tr>
    <tr>
        <th>Current Location</th>
        <td>{{ $current_locate }}</td>
    </tr>
</table>

</body>
</html>
