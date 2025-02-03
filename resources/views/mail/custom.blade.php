<!-- resources/views/emails/custom_email.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
<div style="background-color: #edf2f7; padding: 15px; text-align: center;">
        <h2><strong style="color: #3d4852;">Karuna Sarawak</strong></h2>
        <div style="background-color: white; padding: 25px 35px 25px 25px; margin-right: 250px; margin-left: 250px; margin-top: 30px; margin-bottom: 30px; text-align: left;">
            <p style="color: #3d4852; font-size: 20px; font-weight: bold;">Hello!</p>
            <p style="color: #718096; font-size: 16px;">You are receiving this email because we received a form submission request for "{{ $subject }}".</p>
            <p style="color: #718096; font-size: 16px;">Click the following link to fill the form:</p>
            <p style="color: #718096; font-size: 16px;"><a href="{{ $body }}" target="_blank">{{ $body }}</a></p>
            <p style="color: #718096; font-size: 16px;">If you did not request this form submission, no further action is required.</p>
            <p style="color: #718096; font-size: 16px;">Regards,<br>Karuna Sarawak</p>
        </div>
        <p style="color: #718096;">© 2023 Karuna Sarawak. All rights reserved.</p>
    </div>
</body>
</html>
