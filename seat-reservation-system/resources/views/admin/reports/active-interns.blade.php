<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #2c3e50; margin-bottom: 0; }
        .header p { color: #7f8c8d; margin-top: 5px; }
        .content { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f9fa; text-align: left; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .footer { margin-top: 50px; text-align: right; font-size: 0.8rem; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $date }}</p>
    </div>
    
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Intern Name</th>
                    <th>Email</th>
                    <th>Reservation Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($intern as $intern)
                <tr>
                    <td>{{ $intern->fname }} {{ $intern->lname }}</td>
                    <td>{{ $intern->email }}</td>
                    <td>{{ $intern->reservations_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        Generated on {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>