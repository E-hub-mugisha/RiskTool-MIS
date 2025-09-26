<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resource Requests Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Resource Requests Report</h2>
    <p><strong>Period:</strong> {{ request('start_date') }} - {{ request('end_date') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Resource</th>
                <th>Region</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $req)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $req->resource->item ?? 'N/A' }}</td>
                    <td>{{ $req->region->name ?? 'N/A' }}</td>
                    <td>{{ $req->quantity }}</td>
                    <td>{{ ucfirst($req->status ?? 'pending') }}</td>
                    <td>{{ $req->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
