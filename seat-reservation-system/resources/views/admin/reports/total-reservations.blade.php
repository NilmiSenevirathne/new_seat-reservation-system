<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #2c3e50; margin-bottom: 0; }
        .header p { color: #7f8c8d; margin-top: 5px; }
        .content { margin-top: 30px; text-align: center; }
        .big-number { font-size: 3rem; font-weight: bold; color: #2c3e50; }
        .footer { margin-top: 50px; text-align: right; font-size: 0.8rem; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $date }}</p>
    </div>
    
    <div class="content">
        <p>Total number of reservations for the period:</p>
        <div class="big-number">{{ $count }}</div>
    </div>
    
    <div class="footer">
        Generated on {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>