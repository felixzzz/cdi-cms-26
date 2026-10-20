<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Whistleblowing Report</title>
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2 style="color: #d9534f;">Whistleblowing Report</h2>
    <p><strong>Date:</strong> {{ parseDate($data->created_at)->format("Y-m-d H:i") }}</p>
    <p><strong>Name:</strong> {{ $data->first_name }} {{ $data->last_name }}</p>
    <p><strong>Email:</strong> {{ $data->email }}</p>
    <p><strong>Country:</strong> {{ $data->country->name }}</p>

    <h3>Report Details</h3>
    <p><strong>Topic:</strong> {{ $data->topic->name }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $data->message }}</p>


    <p style="margin-top: 30px; font-size: 12px; color: #999;">
        This message was sent automatically by the system.
    </p>
</body>
</html>
