<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subscribe Form Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: left !important;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            text-align: left !important;
        }

        .email-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .email-content {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .email-footer {
            font-size: 14px;
            color: #555;
            text-align: left !important;
        }

        .comment-content {
            font-style: italic;
            color: #333;
            text-align: left !important;
        }

        .email-header,
        .email-content,
        .email-footer,
        .comment-content {
            text-align: left !important;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">New Subscribe Form Submitted</div>

        <div class="email-content">
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
        </div>

        <div class="email-footer">
            <p>Thank you for subscribing to our newsletter. You will receive our latest news and updates.</p>
        </div>
    </div>
</body>

</html>